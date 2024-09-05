<?php

namespace App\Http\Controllers\admin;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ContactUsController extends Controller
{
    public function index()
    {
        $messages = ContactUs::orderBy('id','desc')->paginate(25);
        return view('AdminPanel.contactUs.index',[
            'active' => 'contactUs',
            'title' => trans('common.contactUs'),
            'messages' => $messages,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.contactUs')
                ]
            ]
        ]);
    }

    public function details($id)
    {
        $message = ContactUs::find($id);
        $message->update(['status'=>'1']);
        if ($message == '') {
            return redirect()->route('admin.contactus');
        }
        $route = route('admin.contactus');
        $title = trans('common.contactUs');
        $active = 'contactUs';
        return view('AdminPanel.contactUs.details',[
            'active' => $active,
            'title' => $title,
            'message' => $message,
            'breadcrumbs' => [
                [
                    'url' => $route,
                    'text' => $title
                ],
                [
                    'url' => '',
                    'text' => trans('common.messageDetails')
                ]
            ]
        ]);
    }

    public function delete($id)
    {
        $message = ContactUs::find($id);
        if ($message->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
