<?php

namespace App\Http\Controllers;

use App\Models\installementLand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstallementLandController extends Controller
{
    //
    public function index()
    {
        $data = installementLand::get();
        return response()->json([
            "message" => "data retrived successfully",
            "data" => $data
        ], 201);
    }
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [

            "client_name" => "required",
            "client_email" => "required|string|unique:installement_lands,client_email",
            "client_country_code" => "required",
            "client_phone" => "required|string|unique:installement_lands,client_phone",
            "client_country" => "required",

        ])->stopOnFirstFailure();

        // Check for validation errors
        if ($validator->fails()) {
            // Get the first error message
            $firstError = $validator->errors()->first();
            return response()->json(['error' => $firstError], 422);
        }
        $data = installementLand::create($request->all());
        return response()->json([
            "message" => "data inserted successfully",
            "data" => $data
        ], 201);
    }
}
