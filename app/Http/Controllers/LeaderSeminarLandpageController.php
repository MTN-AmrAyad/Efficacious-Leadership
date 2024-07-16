<?php

// app/Http/Controllers/LeaderSeminarLandpageController.php

namespace App\Http\Controllers;

use App\Models\LeaderSeminarLandpage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaderSeminarLandpageController extends Controller
{
    public function createSeminar(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string',
            'client_email' => 'required|email|unique:leader_seminar_landpages,client_email',
            'client_job' => 'required|string',
            'client_country' => 'required|string',
            'client_country_code' => 'required|string',
            'client_phone' => 'required|string|unique:leader_seminar_landpages,client_phone',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new leadership seminar landpage
        $seminar = LeaderSeminarLandpage::create($request->all());

        return response()->json(['message' => 'Seminar created successfully', 'data' => $seminar], 201);
    }

    public function review()
    {
        $data = LeaderSeminarLandpage::all();
        return response()->json(['status' => "200", 'data' => $data], 200);
    }
}
