<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Service;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {

        if (!userCan('fields_view')) {
            return redirect()->route('admin.index')
                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $fields = Field::orderBy('id')->paginate(10);

        return view('AdminPanel.fields.index',[
            'active' => 'fields',
            'title' => 'المجالات',
            'fields' => $fields,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => 'المجالات'
                ]
            ]
        ]);

    }
    public function store(Request $request)
    {
        if (!userCan('fields_create')) {
            return redirect()->route('admin.index')
                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $field = Field::create($data);
        if ($field) {
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }
    public function update(Request $request, $id)
    {
        if (!userCan('fields_edit')) {
            return redirect()->route('admin.index')
                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $fields = Field::find($id);
        $data = $request->except(['_token']);
        $update = $fields->update($data);

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
        if (!userCan('fields_delete')) {
            return redirect()->route('admin.index')
                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $field = Field::find($id);

        $field->delete();
        return Response::json($id);
    }
}
