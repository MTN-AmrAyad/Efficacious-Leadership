<?php

namespace App\Http\Controllers;

use App\Models\LivingFetra;
use Illuminate\Http\Request;

class LivingFetraController extends Controller
{
    //
    public function index()
    {
        $data = LivingFetra::get();
        return response()->json([
            "message" => "data retrived successflly",
            "data" => $data
        ], 201);
    }

    public function store(Request $request)
    {
        $data = LivingFetra::create($request->all());
        return response()->json([
            "message" => "data created successflly",
            "data" => $data
        ], 201);
    }
}
