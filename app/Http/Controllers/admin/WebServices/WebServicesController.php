<?php

namespace App\Http\Controllers\admin\WebServices;

use App\Models\WebService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class WebServicesController extends Controller
{
    public function index()
    {

        $services = WebService::orderBy('id')->paginate(10);
        return view('AdminPanel.webservices.index',[
            'active' => 'webservices',
            'title' => trans('common.Web Services'),
            'services' => $services,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Web Services')
                ]
            ]
        ]);

    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar'=>'required|string|max:255',
            'description_en'=>'required|string|max:255',
            'image' => 'nullable|mimes:jpg,bmp,png',
            'price' => 'required|string|numeric',
            'contact' => 'required|string|',
            'category' => 'required|in:remote,inside'



        ]);
        $data = $request->except(['_token', 'image']);

        if ($request->hasFile('image')) {
            $data['image'] = upload_file('Webservices', $request->image);
        }


        $service = WebService::create($data);
        if ($service) {
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }
    public function update(Request $request, $id)
    {
        $service = WebService::find($id);
        $data = $request->except(['_token']);
        if ($request->hasFile('image')) {
            if ($service->image) {
                $this->deleteImage('services/', $service->image);
            }
            $data['image'] = upload_file('webservices', $request->image);
        }
        $update = $service->update($data);

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
        $service = WebService::find($id);
        if ($service->image) {
            $this->deleteImage('services', $service->image);
        }
        $service->delete();
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
