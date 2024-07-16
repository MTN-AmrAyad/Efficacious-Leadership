<?php

namespace App\Http\Controllers;

use App\Models\ClienData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ClienDataController extends Controller
{
    // Function retiverd data from `clien_data` table
    public function index()
    {
        $clients = ClienData::all();
        return response()->json([
            'message' => 'Retrived Data successfully',
            'data' => $clients
        ], 200);
    }

    // Function insertion data from `clien_data` table
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_email' => 'required|email|unique:clien_data',
            'client_phone' => 'required|unique:clien_data'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'message' => 'You already Registered',


            ], 501);
        } else {
            $registraions = ClienData::create($request->all());
            ClienDataController::sendMessage($request);
            return response()->json([
                'message' => 'Regstration successfully',
                'data' => $registraions,
            ], 200);
        }
    }
    
    // Function with built in api check the number of whatsapp exist or not using wo-wa 
     public function whatsapp(Request $request)
    {



        $phone_no = $request->input('phone');
        $key = '7af3ea03861900427088879ae99350a1c09956021cb0b23b'; //this is demo key please change with your own key
        $url = 'http://116.203.191.58/api/check_number';
        $data = array(
            "phone_no" => $phone_no,
            "key"    => $key
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
        if ($res == "exists") {
            return response()->json([
                'message' => $res
            ], 200);
        } else {
            return response()->json([
                'message' => $res
            ], 400);
        }

        curl_close($ch);
     
    }
    // Function caled in the insert to send message after inserting 
    public function sendMessage(Request $request)
    {
        $phone = $request->input('client_phone');
        $code = $request->input('client_country_code');
        $phone_no = $code.$phone; 
        $key = '7af3ea03861900427088879ae99350a1c09956021cb0b23b'; //this is demo key please change with your own key
        $url = 'http://116.203.191.58/api/send_message';
        $message ='*إنتظرونا* الأحد القادم (24 مارس) في *ويبنار*  *((Natural Leadership Power))* استفد من *قوة وتأثير قيادتك الفطرية*. 

👈🏻انتظرونا في البث المباشر  يوم 31 مارس 👇🏻
https://www.youtube.com/@ELDEMELLAWYOFFICiAL

للأشتراك وتلقي الإستفسارات عبر تطبيق الزووم 👇🏻: 
https://us02web.zoom.us/j/82731263186?pwd=WW52QktkTFdiaGJCUWlkTFpyZnd3dz09
*في التوقيتات* :
▫️2:00 مساء بتوقيت السعودية
▫️3:00مساء بتوقيت الامارات 

للإستفسار :
https://wa.me/message/VVDODXOQNQECF1

▫️▫️▫️▫️▫️▫️▫️▫️
*شاهد الآن أهم ما يجب أن تعرفه عن القيادة الفعالة* 👇🏻
https://youtu.be/lf212c1HtFA';
        $data = array(
            "phone_no"  => $phone_no,
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
        echo $res = curl_exec($ch);
        curl_close($ch);
    }
    
    
    
    // get data to insert into review sheet and inserted in the client_data
    public function getData($phone)
    {
        // Retrieve user data based on the phone number using raw SQL query
        $userData = DB::table('userData')
            ->where('phone', $phone)
            ->first(); // Use first() to retrieve a single record

        // Check if any data was found
        if (!$userData) {
            // No data found for the given phone number
            return response()->json(['message' => 'No data found for the given phone number'], 404);
            exit();
        }

        // Extract necessary data from the retrieved user data
        $insertData = [
            "client_name" => $userData->name,
            "client_email" => $userData->email,
            "client_job" => $userData->work,
            "client_country" => $userData->city,
            "client_phone" => $userData->phone,
        ];

        // Create a new instance of ClienData using the extracted data
        $registration = ClienData::create($insertData);

        // Return the created registration data as JSON response
        // return response()->json($registration);
    }

    public function check($phone)
    {
        $client = ClienData::where('client_phone', $phone)->first();
        if (!$client) {
            // No data found for the given phone number
            ClienDataController::getData($phone);
            return true;
        } else {
            return false;
        }
    }


    public function reg($type, $phone)
    {
        $instaUrl = "https://www.instagram.com/reel/C4H-T9jtTB8/?igsh=ZXNlOTlmMDQ0OHA2/" . $type . "/" . $phone;
        $recordeYoutube = "https://youtu.be/lf212c1HtFA" . $type . "/" . $phone;
        $youtubeUrl = "https://www.youtube.com/@ManageTheNowlive" . $type . "/" . $phone;
        $zoomUrl = "https://us02web.zoom.us/j/81439354277?pwd=MVI2ZVI1enNDUzFNNjlqVWI3MS9tUT09" . $type . "/" . $phone;
        $newPhone = $phone;
        if ($type == "insta") {
            $check = ClienDataController::check($newPhone);
            if ($check = true) {
                // header("Location: " . $instaUrl);
                header('Location: https://www.instagram.com/reel/C4H-T9jtTB8/?igsh=ZXNlOTlmMDQ0OHA2/');
                exit();
            } else {
                // header("Location: " . $instaUrl);
                header('Location: https://www.instagram.com/reel/C4H-T9jtTB8/?igsh=ZXNlOTlmMDQ0OHA2/');
                exit();
            }
        } else if ($type == "recorded") {
            $check = ClienDataController::check($newPhone);
            if ($check = true) {
                // header("Location: " . $recordeYoutube);
                header('Location: https://youtu.be/lf212c1HtFA');
                exit();
            } else {
                // header("Location: " . $recordeYoutube);
                header('Location: https://youtu.be/lf212c1HtFA');
                exit();
            }
        } elseif ($type == "youtube") {
            $check = ClienDataController::check($newPhone);
            if ($check = true) {
                // header("Location: " . $youtubeUrl);
                header('Location:https://www.youtube.com/@ManageTheNowlive');
                exit();
            } else {
                // header("Location: " . $youtubeUrl);
                header('Location:https://www.youtube.com/@ManageTheNowlive');
                exit();
            }
        } elseif ($type == "zoom") {
            $check = ClienDataController::check($newPhone);
            if ($check = true) {
                // header("Location: " . $zoomUrl);
                header('Location:https://us02web.zoom.us/j/81439354277?pwd=MVI2ZVI1enNDUzFNNjlqVWI3MS9tUT09');
                exit();
            } else {
                // header("Location: " . $zoomUrl);
                header('Location:https://us02web.zoom.us/j/81439354277?pwd=MVI2ZVI1enNDUzFNNjlqVWI3MS9tUT09');
                exit();
            }
        }
    }
    
    
   




    // }
}
