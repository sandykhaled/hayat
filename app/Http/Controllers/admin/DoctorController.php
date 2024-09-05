<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class DoctorController extends Controller
{
    public function index()
    {

        $doctors = Doctor::orderBy('id')->paginate(10);
        return view('AdminPanel.doctors.index',[
            'active' => 'doctors',
            'title' => trans('common.doctors'),
            'doctors' => $doctors,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.doctors')
                ]
            ]
        ]);

    }
    public function store(Request $request)
    {
       $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'jobTitle' => 'required|string|max:255',
        'linkedInLink' => 'nullable|url',
        'twitterLink' => 'nullable|url',
        'whatsappLink' => 'nullable|url',
        'photo' => 'nullable|mimes:jpg,bmp,png',
    ]);
        $validatedData = $request->except(['_token', 'photo']);

   if ($request->hasFile('photo')) {
            $validatedData['photo'] = upload_file('doctors', $request->photo);
        }
    $doctor = Doctor::create($validatedData);
        if ($doctor) {
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }

  public function update(Request $request, $id)
{
    $validationRules = [
        'title_ar' => 'string|max:255',
        'title_en' => 'string|max:255',
        'description_ar'=>'string|max:255',
        'description_en'=>'string|max:255',
        'photo' => 'nullable|mimes:jpg,bmp,png',
    ];

    $validator = Validator::make($request->all(), $validationRules);

if ($validator->fails()) {
    return redirect()->back()->withErrors($validator)->withInput();
}

$doctor = Doctor::find($id);
$data = $request->except(['_token', 'photo']);

if ($request->hasFile('photo')) {
    if ($doctor->photo) {
        $this->deleteImage('doctors', $doctor->photo);
    }
    $data['photo'] = upload_file('doctors', $request->photo);
}

$update = $doctor->update($data);

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
        $doctor = Doctor::find($id);
        if ($doctor->photo) {
            $this->deleteImage('doctors', $doctor->photo);
        }
        $doctor->delete();
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
