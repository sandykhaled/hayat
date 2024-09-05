<?php

namespace App\Http\Controllers\admin\result;

use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;



class ResultController extends Controller
{
    public function index()
    {

        $results = Result::orderBy('id')->paginate(10);
        return view('AdminPanel.results.index',[
            'active' => 'results',
            'title' => trans('common.results'),
            'results' => $results,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.results')
                ]
            ]
        ]);

    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date',
            'video' => 'nullable|mimes:mp4,avi,wmv',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',

        ]);
        $data = $request->except(['_token' , 'video']);


        if ($request->hasFile('video')) {
            $data['video'] = upload_file('results', $request->video);
        }

        $result = Result::create($data);
        if ($result) {
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }
    public function update(Request $request, $id)
    {
        $results = Result::find($id);
        $data = $request->except(['_token']);
        if ($request->hasFile('video')) {
            if ($results->video) {
                $this->deleteImage('results/', $results->video);
            }
            $data['video'] = upload_file('results', $request->video);
        }
        $update = $results->update($data);

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
        $result = Result::find($id);
        $result->delete();
        return Response::json($id);
    }

}
