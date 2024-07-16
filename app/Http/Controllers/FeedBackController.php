<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class FeedBackController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_email' => 'required|email|unique:feed_backs,client_email',
            'client_phone' => 'required|unique:feed_backs,client_phone',
            'isLeading' => 'required'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'message' => 'You already Registered',
            ], 501);
        } else {
            $registraions = FeedBack::create($request->all());
            return response()->json([
                'message' => 'Regstration successfully',
                'data' => $registraions,
            ], 200);
        }
    }
    
    public function review()
    {
        $data = FeedBack::all();
        return response()->json([
            'message' => 'Data Retrieved successfully',
            'data' => $data
        ], 200);
    }
   

}
