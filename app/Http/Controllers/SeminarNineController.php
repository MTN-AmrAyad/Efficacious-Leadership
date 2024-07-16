<?php

namespace App\Http\Controllers;

use App\Models\SeminarNine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeminarNineController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "client_name" => "required|string",
            "client_email" => "required|email|unique:seminar_nines,client_email",
            "client_country" => "required|string",
            "client_country_code" => "required|string",
            "client_phone" => "required|string|unique:seminar_nines,client_phone",
            "self_interste" => "required",
            "relationship_interest" => "required",
            "work_interest" => "required",
            "attend_in_transformational_leadership" => "required",

        ])->stopOnFirstFailure();

        if ($validator->fails()) {
            // Get the first error message
            $firstError = $validator->errors()->first();
            return response()->json(['error' => $firstError], 422);
        }
        $registration = SeminarNine::create($request->all());
        return response()->json([
            "message" => "success",
        ], 201);
    }

    public function index()
    {
        $data = SeminarNine::all();
        return response()->json([
            "message" => "retrieving successful",
            "data" => $data,
        ], 201);
    }
}
