<?php

namespace App\Http\Controllers;

use App\Models\LeaderShipAugest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaderShipAugestController extends Controller
{
    public function LeaderAugest(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string',
            'client_email' => 'required|email|unique:leader_ship_augests,client_email',
            'client_country' => 'required|string',
            'client_country_code' => 'required|string',
            'client_phone' => 'required|string|unique:leader_ship_augests,client_phone',
            'client_job' => 'required|string',
            'know_us' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new leadership seminar landpage
        $seminar = LeaderShipAugest::create($request->all());

        return response()->json(['message' => 'Seminar created successfully', 'data' => $seminar], 201);
    }

    public function review()
    {
        $data = LeaderShipAugest::all();
        return response()->json(['status' => "200", 'data' => $data], 200);
    }
}
