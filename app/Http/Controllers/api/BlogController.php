<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Resources\ServiceResource;
use App\Models\Blog;
use App\Models\Service;
use Illuminate\Http\Request;

class BlogController extends Controller
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

       $blogs = Blog::with('images')->get();
       return response()->json(BlogResource::collection($blogs));
    }
    public function show($id)
    {
        $blogs = Blog::find($id);
        return response()->json(new BlogResource($blogs));

    }
}
