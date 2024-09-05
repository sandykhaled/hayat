<?php

namespace App\Http\Controllers\admin;


use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ServicesController extends Controller
{
    public function index()
    {
        if (!userCan('services_view')) {
            return redirect()->route('admin.index')
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }

        $services = Service::orderBy('name','asc')->paginate(25);
        return view('AdminPanel.services.index',[
            'active' => 'services',
            'title' => trans('common.services'),
            'services' => $services,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.services')
                ]
            ]
        ]);
    }



    public function store(Request $request)
    {
        if (!userCan('services_create')) {
            return redirect()->back()
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $service = Service::create($data);
        if ($service) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('services_edit')) {
            return redirect()->back()
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $service = Service::find($id);
        $data = $request->except(['_token']);

        $update = Service::find($id)->update($data);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function delete($id)
    {
        if (!userCan('services_delete')) {
            return Response::json("false");
        }
        $service = Service::find($id);
        if ($service->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
