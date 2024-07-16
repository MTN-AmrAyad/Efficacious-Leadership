<?php

namespace App\Http\Controllers;

use App\Models\MainDataSQr;
use App\Models\PatchTwoSQr;
use Illuminate\Http\Request;

class PatchTwoSQrController extends Controller
{
    public function QRcode($phone_number)
    {
        // Find the MainData QR based on client phone number
        $data = MainDataSQr::where('phone', $phone_number)->first();

        if ($data) {
            // Construct the final phone number
            // $final_number = $communication->client_country_code . $phone_number;
            $name = $data->name;
            $email = $data->email;

            // Create a new CommunicationQR record if validations pass
            $newQR = PatchTwoSQr::create([
                "name" => $name,
                "email" => $email,
                "phone" => $phone_number,
            ]);
            // return response()->json([
            //     'stauts' => true,
            //     'message' => "Successfully Scanned QR Code",
            //     'data' => $newQR,
            // ]);
            return redirect('https://managethenow.com/checkqr/communication/correct');
        } else {
            // Handle case where no matching client is found for the given phone number
            // return response()->json(['error' => 'Client not found'], 404);
            return redirect('https://managethenow.com/checkqr/communication/wrong/');
        }
    }

    public function getAllQRcode()
    {
        $data = PatchTwoSQr::all();
        return response()->json([
            "status" => true,
            "message" => "data retrieved successfully",
            "data" => $data
        ], 201);
    }
}
