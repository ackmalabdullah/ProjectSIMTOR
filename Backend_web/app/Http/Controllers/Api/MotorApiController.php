<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Motor;

class MotorApiController extends Controller
{
    public function index()
    {
        $motor = Motor::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Data motor berhasil diambil',
            'data' => $motor
        ]);
    }

    public function show($id)
    {
        $motor = Motor::find($id);

        if (!$motor) {
            return response()->json([
                'status' => false,
                'message' => 'Motor tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $motor
        ]);
    }
}