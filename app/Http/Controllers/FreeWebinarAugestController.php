<?php

namespace App\Http\Controllers;

use App\Models\FreeWebinarAugest;
use Illuminate\Http\Request;

class FreeWebinarAugestController extends Controller
{
    //
    public function store(Request $request)
    {
        $data = FreeWebinarAugest::create($request->all());
        return response()->json([
            "message" => "success",
            "data" => $data
        ], 201);
    }

    public function index()
    {
        $data = FreeWebinarAugest::all();
        return response()->json([
            "message" => "success retrieving",
            "data" => $data
        ], 201);
    }
}
