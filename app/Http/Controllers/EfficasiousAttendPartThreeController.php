<?php

namespace App\Http\Controllers;

use App\Models\EfficasiousAttendPartThree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EfficasiousAttendPartThreeController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string',
            'client_email' => 'required|email|unique:efficasious_attend_part_threes,client_email',
            'client_job' => 'required|string',
            'client_country' => 'required|string',
            'client_country_code' => 'required|string',
            'client_phone' => 'required|string|unique:efficasious_attend_part_threes,client_phone',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Create a new leadership seminar landpage
        $seminar = EfficasiousAttendPartThree::create($request->all());

        return response()->json(['message' => 'Seminar created successfully', 'data' => $seminar], 201);
    }

    public function index()
    {
        $data =  EfficasiousAttendPartThree::all();
        return response()->json($data);
    }
}
