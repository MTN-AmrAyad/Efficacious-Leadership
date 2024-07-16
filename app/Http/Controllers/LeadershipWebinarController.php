<?php

namespace App\Http\Controllers;

use App\Models\LeadershipWebinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;


class LeadershipWebinarController extends Controller
{
    public function index()
    {
        $data = LeadershipWebinar::get();
        return response()->json([
            "message" => "data retrieved successfully",
            "data" => $data
        ], 201);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [

            "client_name" => "required",
            "client_email" => "required|string|unique:leadership_webinars,client_email",
            "client_country" => "required",
            "client_country_code" => "required",
            "client_phone" => "required|string|unique:leadership_webinars,client_phone",
            "client_job" => "required",
        ])->stopOnFirstFailure();

        // Check for validation errors
        if ($validator->fails()) {
            // Get the first error message
            $firstError = $validator->errors()->first();
            return response()->json(['error' => $firstError], 422);
        }

        $data = LeadershipWebinar::create($request->all());
        LeadershipWebinarController::ERPLogin($request);

        return response()->json([
            "message" => "informational created successfully",
            "data" => $data,
        ], 201);
    }

    // login to ERP and insert lead from form to ERP Lead
    public function ERPLogin(Request $request)
    {

        $finalphone = $request->client_country_code . $request->client_phone;


        $response = Http::withHeaders([
            'Authorization' => 'Basic NWE4ZjBhODU3YjIyYWJmOmUxOWU3OGMxMjQ2MDY0OQ==',
        ])->post('https://mtn.smartsoleg.com/api/resource/Lead', [
            "project" => "leadership_webinar",
            "lead_name" => $request->client_name,
            "lead_country" => $request->client_country,
            "phone" => $finalphone,
            "email_id" => $request->client_email,

        ]);
    }
}
