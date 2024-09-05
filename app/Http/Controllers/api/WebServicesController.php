<?php

namespace App\Http\Controllers\api;

use App\Models\WebService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WebServiceResource;

class WebServicesController extends Controller
{
    public function WebServices(Request $request)
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

        $services = WebService::paginate(25);
        return WebServiceResource::collection($services);

    }


}


