<?php

namespace App\Http\Controllers;

use App\Models\LivingFetraMainPro;
use App\Models\LivingFetraQRMainPro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LivingFetraMainProController extends Controller
{
    // function to retrive all date
    public function index()
    {
        $data = LivingFetraMainPro::all();
        return response()->json([
            "message" => "date retrieved successfully",
            "data" => $data
        ], 201);
    }
    // function to store date

    public function store(Request $request)
    {
        // make the validation of request
        $valdiator = Validator::make($request->all(), [
            "client_name" => "required",
            "client_email" => "required|unique:living_fetra_main_pros,client_email",
            "client_job" => "required",
            "client_country" => "required",
            "client_country_code" => "required",
            "client_phone" => "required|unique:living_fetra_main_pros,client_phone",

        ])->stopOnFirstFailure();
        //check the Validation if failed
        if ($valdiator->fails()) {
            //get the first error message
            $firstError = $valdiator->errors()->first();
            return response()->json(['error' => $firstError], 422);
        }
        $phone = $request->client_country_code . $request->client_phone;
        $client_name = $request->client_name;

        $checkSet = LivingFetraMainPro::where('section_sets', $request->section_sets)
            ->where('chair_number', $request->chair_number)->first();
        if ($checkSet) {
            return response()->json('this set is already reversed');
        }

        $dataReg = LivingFetraMainPro::create($request->all());
        $id = $dataReg->id;
        $client_name = $dataReg->$client_name;
        // EbtAdvancedAugestController::sendMessage($request , $id,$client_name);
        if (!$dataReg) {
            return response()->json([
                "error" => "error",
            ]);
        }
        return response()->json($dataReg);
    }
    //get client by id
    public function getClientById($id)
    {
        $client = LivingFetraMainPro::find($id);
        if (!$client) {
            return response()->json([
                "message" => "Id not found",

            ]);
        }
        return response()->json([$client]);
    }

    public function checkChair()
    {
        // Fetch all chair numbers and section sets from the FeelingMedcineAttend table
        $data = LivingFetraMainPro::all(['chair_number', 'section_sets']);
        $dataCount = $data->count();
        // return response()->json($dataCount);

        // Initialize arrays for sections
        $sections = [
            'section1' => [],
            'section2' => [],
            'section3' => [],
            'section4' => []
        ];

        // Iterate through the data and categorize into sections based on section_sets
        foreach ($data as $record) {
            $chairNumber = (int)$record->chair_number;
            $sectionSet = $record->section_sets;

            // Categorize chair number based on section_sets value
            switch ($sectionSet) {
                case 'section1':
                    $sections['section1'][] = $chairNumber;
                    break;
                case 'section2':
                    $sections['section2'][] = $chairNumber;
                    break;
                case 'section3':
                    $sections['section3'][] = $chairNumber;
                    break;
                case 'section4':
                    $sections['section4'][] = $chairNumber;
                    break;
            }
        }

        // Return the response
        return response()->json([
            'sections' => $sections,
            'reservedCount' => $dataCount
        ], 200);
    }

    // Function caled in the insert to send message after inserting
    public function sendMessage($id)
    {
        $client = LivingFetraMainPro::find($id);
        if (!$client) {
            return response()->json([
                "message" => "something went wrong",

            ]);
        }

        $phoneNumber = $client->client_phone;
        $codeNumber = $client->client_country_code;
        $client_name = $client->client_name;
        $phone = $codeNumber . $phoneNumber;

        $key = '53e6845a7bc50f05f3bee7133ebe9994690f1d6aa78d56df'; //this is demo key please change with your own key
        $url = 'http://116.203.191.58/api/send_message';

        $message = '✨لقد تم تأكيد حجز مقعدك في برنامج *تقنية الاتزان العاطفي - المستوي المتقدم*

✨ الذي يبدأ 15 أغسطس ويستمر حتى 19 أغسطس

⏰ الساعة 4:30 مساء بتوقيت القاهرة

⬅️ ال ID 👇🏻

https://managethenow.com/forms/ebt-advanced/ticket/?id=' . $id . '


📍اللوكيشن 👇🏻
https://maps.app.goo.gl/dakZV4bXonMwcRvn6';




        $data = array(
            "phone_no"  => $phone,
            "key"       => $key,
            "message"   => $message,
            "skip_link" => True, // This optional for skip snapshot of link in message
            "flag_retry"  => "on", // This optional for retry on failed send message
            "pendingTime" => 3 // This optional for delay before send message
        );
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $res = curl_exec($ch);
        curl_close($ch);
    }

    public function scanQrEbtAdvanced($id, $key)
    {
        $client = LivingFetraMainPro::find($id);
        if (!$client) {
            return response()->json([
                "error" => "Id client not found"
            ], 400);
        }

        $decodedKey = base64_decode($key);
        // $inputKey = $request->passCode;
        if ($decodedKey === "test") {
            $QrClient = LivingFetraQRMainPro::create([
                "client_name" => $client->client_name,
                "client_email" => $client->client_email,
                "client_country_code" => $client->client_country_code,
                "client_phone" => $client->client_phone,
            ]);
            return response()->json([
                "message" => "Client Scanned QR Code",
                "client" => $QrClient
            ]);
        }
        return response()->json([
            "error" => "key not valid"
        ], 400);
    }

    public function getQr()
    {
        $data = LivingFetraQRMainPro::get();
        return response()->json([
            "message" => "data retrived successfully",
            "data" => $data

        ], 201);
    }
}
