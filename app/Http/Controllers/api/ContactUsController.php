<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\service;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public function sendContactMessage(Request $request)
    {
        $lang = $request->header('lang');
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        $rules = [
            'name' => 'required',
            'email' => 'required|email|',
            'phone' => 'required',
            'message' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            foreach ((array)$validator->errors() as $error) {
                return response()->json([
                    'status' => 'faild',
                    'message' => trans('api.pleaseRecheckYourDetails'),
                    'data' => $error
                ]);
            }
        }

        $data = $request->except(['_token']);

        $message = ContactUs::create($data);
        if ($message) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSentSuccessfully'),
                'data' => []
            ];
        } else {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.someThingWentWrong'),
                'data' => []
            ];
        }
        return response()->json($resArr);
    }

    public function getContactMessages(Request $request)
    {
        $lang = $request->header('lang');
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        $messages = ContactUs::orderBy('id', 'desc')->paginate(25);
        if ($messages) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.dataRetrievedSuccessfully'),
                'data' => $messages
            ];
        } else {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.noDataFound'),
                'data' => []
            ];
        }
        return response()->json($resArr);
    }
}
