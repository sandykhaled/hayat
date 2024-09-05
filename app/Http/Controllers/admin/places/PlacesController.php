<?php

namespace App\Http\Controllers\admin\places;

use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class PlacesController extends Controller
{
    public function index()
    {

        $places = Place::orderBy('id')->paginate(10);
        return view('AdminPanel.places.index',[
            'active' => 'places',
            'title' => trans('common.places'),
            'places' => $places,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.places')
                ]
            ]
        ]);

    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'address_ar'=>'required|string|max:255',
            'address_en'=>'required|string|max:255',
            'image' => 'nullable|mimes:jpg,bmp,png',
            'location_url' => 'required|string',

        ]);
        $data = $request->except(['_token', 'image']);

        if ($request->hasFile('image')) {
            $data['image'] = upload_file('places', $request->image);
        }


        $place = Place::create($data);
        if ($place) {
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }
    public function update(Request $request, $id)
    {
        $place = Place::find($id);
        $data = $request->except(['_token']);
        if ($request->hasFile('image')) {
            if ($place->image) {
                $this->deleteImage('places', $place->image);
            }
            $data['image'] = upload_file('places', $request->image);
        }
        $update = $place->update($data);

        if ($update) {
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }
    public function delete($id)
    {
        $place = Place::find($id);
        if ($place->image) {
            $this->deleteImage('services', $place->image);
        }
        $place->delete();
        return Response::json($id);
    }
    private function deleteImage($folder, $fileName)
    {
        $filePath = public_path('uploads/' . $folder . '/' . $fileName);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }
}
