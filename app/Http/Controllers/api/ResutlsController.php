<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResultResource;
use App\Models\Result;
use Illuminate\Http\Request;

class ResutlsController extends Controller
{
    public function index(Request $request)
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

       $results = Result::paginate(25);
        return ResultResource::collection($results);

    }

    public function show($id)
    {
        $results = Result::find($id);
        return response()->json(new ResultResource($results));
    }
}
