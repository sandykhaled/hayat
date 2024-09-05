<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::orderBy('id')->paginate(10);
        $services = Service::select('name', 'id')->get()->unique('name');
        return view('AdminPanel.offers.index', [
            'active' => 'offers',
            'title' => 'العروض',
            'offers' => $offers,
            'services'=>$services,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => 'العروض'
                ]
            ]
        ]);

    }
    public function store(Request $request)
    {
        if (!userCan('offers_create')) {
            return redirect()->back()
                ->with('PopError', trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token', 'services']);
        if ($request->services == '') {
            return redirect()->back()
                ->with('faild', trans('common.youHaveToAssignOnePermissionAtLeast'));
        }

        $offer = Offer::create($data);
        if ($offer) {
            foreach ($request->services as $value) {
                $offer->services()->attach($value);
            }
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }
        public function update(Request $request,$id)
    {
        $data = $request->except(['_token','services']);
        if ($request->services == '') {
            return redirect()->back()
                ->with('faild',trans('common.youHaveToAssignOnePermissionAtLeast'));
        }
        $offer = Offer::find($id);
        $offer->services()->detach();
        $offer->update($data);
        foreach ($request->services as $value) {
            $offer->services()->attach($value);
        }
        if ($offer) {
            return redirect()->back()
                ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function delete($id)
    {
        $offer = Offer::find($id);
        $offer->services()->detach();
        if ($offer->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }

}
