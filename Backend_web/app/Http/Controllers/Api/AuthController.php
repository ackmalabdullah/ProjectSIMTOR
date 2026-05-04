<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // 🔥 REGISTER EMAIL
    public function register(Request $request)
    {
        // ✅ VALIDASI
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ BUAT USER BARU
        try {
            $user = Users::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'aktif',
                'role' => 'user',
                'provider' => 'email',
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => true,
                'message' => 'Register berhasil',
                'token' => $token,
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Register gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 🔥 CARI USER MANUAL (MONGODB)
            $user = Users::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email atau password salah'
                ], 401);
            }

            // 🔥 BUAT TOKEN MANUAL
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Login gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🔥 LOGIN GOOGLE
    public function socialLogin(Request $request)
    {
        // ✅ VALIDASI
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'firebase_uid' => 'required|string',
            'nama' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $nama = $request->nama ?? 'User';
            $email = $request->email;
            $firebase_uid = $request->firebase_uid;

            // ✅ CEK USER
            $user = Users::where('email', $email)->first();

            if (!$user) {
                // BUAT USER BARU
                $user = Users::create([
                    'nama' => $nama,
                    'email' => $email,
                    'username' => explode('@', $email)[0] . '_' . uniqid(),
                    'firebase_uid' => $firebase_uid,
                    'provider' => 'google',
                    'role' => 'user',
                    'status' => 'aktif',
                ]);
            } else {
                // UPDATE DATA KALAU ADA PERUBAHAN
                $user->update([
                    'nama' => $nama,
                    'firebase_uid' => $firebase_uid,
                ]);
            }

            // ✅ BUAT TOKEN
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => true,
                'message' => 'Login Google berhasil',
                'token' => $token,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Social login gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🔥 PROFILE (BUTUH TOKEN)
    public function profile()
    {
        try {
            $user = auth()->user();
            return response()->json([
                'status' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🔥 LOGOUT
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => true,
                'message' => 'Logout berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Logout gagal: ' . $e->getMessage()
            ], 500);
        }
    }
}
