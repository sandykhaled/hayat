<?php

namespace App\Http\Controllers\api;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;

class DoctorController extends Controller
{
     public function index(Request $request)
    {

        $doctors = Doctor::all();
        return response()->json(DoctorResource::collection($doctors));
    }
    public function show($id)
    {
        $doctor = Doctor::find($id);
        return response()->json(new DoctorResource($doctor));

    }
}
