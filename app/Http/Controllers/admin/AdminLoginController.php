<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    //
    public function login()
    {
        return view('AdminPanel.auth.login',[
            'active' => '',
            'title' => trans('common.Sign in')
        ]);
    }
}
