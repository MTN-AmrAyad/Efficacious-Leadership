<?php

namespace App\Http\Controllers;

use App\Models\GenerateVochuerPatch3;
use Illuminate\Http\Request;

class GenerateVochuerPatch3Controller extends Controller
{
    public function store(Request $request)
    {
        $data = GenerateVochuerPatch3::create($request->all());
        return response()->json([
            "message" => "success",
            "data" => $data
        ], 201);
    }

    public function index()
    {
        $data = GenerateVochuerPatch3::all();
        return response()->json([
            "message" => "success retrieving",
            "data" => $data
        ], 201);
    }
}
