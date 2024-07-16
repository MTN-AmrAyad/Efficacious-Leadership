<?php

namespace App\Http\Controllers;


use App\Models\EfficaciousLeadership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;


class EfficaciousLeadershipController extends Controller
{

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "client_name" => "required|string",
            "client_email" => "required|email|unique:efficacious_leaderships,client_email",
            // "client_job" => "required|string",
            // "client_country" => "required|string",
            "client_country_code" => "required|string",
            "client_phone" => "required|string|unique:efficacious_leaderships,client_phone",

        ])->stopOnFirstFailure();

        if ($validator->fails()) {
            // Get the first error message
            $firstError = $validator->errors()->first();
            return response()->json(['error' => $firstError], 422);
        } else {
            $regstration = EfficaciousLeadership::create($request->all());
            
            if(!$regstration){
                return response()->json([
                'message' => 'Error in Query ',
            ], 403);
            }else{
            // after create the lead from landpage login to ERP to get credintials
            EfficaciousLeadershipController::ERPLogin($request);

            }
            
            return response()->json([
                'message' => 'Registration Successfully ',
                'data' => $regstration
            ], 201);
        }
    }

    public function review()
    {
        $data = EfficaciousLeadership::all();
        return response()->json([
            'message' => 'Data Retrieved successfully',
            'data' => $data
        ], 200);
    }
    
    // login to ERP and insert lead from form to ERP Lead
    public function ERPLogin(Request $request)
    {
        
     $finalphone= $request->client_country_code.$request-> client_phone;
  
       
       $response = Http::withHeaders([
    'Authorization' => 'Basic NWE4ZjBhODU3YjIyYWJmOmUxOWU3OGMxMjQ2MDY0OQ==',
])->post('https://mtn.smartsoleg.com/api/resource/Lead', [
   "project" =>"Leadership_landpage",
    "lead_name" =>$request->client_name,
    "lead_country" =>"Egypt",
    "phone"=>$finalphone,
    "email_id"=>$request->client_email,
    
]);
       



              
                
    
                       

     
    }
    
    
    
    
    
}
