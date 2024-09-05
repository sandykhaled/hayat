<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    public function places(Request $request)
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

        $places = Place::paginate(25);
        return PlaceResource::collection($places);

    }
}
