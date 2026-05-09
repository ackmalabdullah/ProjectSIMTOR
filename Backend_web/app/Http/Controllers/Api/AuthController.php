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
    // REGISTER
    public function register(Request $request)
    {
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

    // LOGIN
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
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
            $user = Users::where('email', $request->email)
                ->orWhere('username', $request->email)
                ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email/Username atau password salah'
                ], 401);
            }

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

    // SOCIAL LOGIN (GOOGLE) - FINAL
    public function socialLogin(Request $request)
    {
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
            $email = $request->email;
            $firebaseUid = $request->firebase_uid;
            $nama = $request->nama ?? 'User';

            // Cari user berdasarkan firebase_uid atau email
            $user = Users::where('firebase_uid', $firebaseUid)->orWhere('email', $email)->first();

            if (!$user) {
                // Buat username unik
                $baseUsername = explode('@', $email)[0];
                $username = $baseUsername;
                $counter = 1;
                while (Users::where('username', $username)->exists()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }

                $user = Users::create([
                    'nama' => $nama,
                    'email' => $email,
                    'username' => $username,
                    'firebase_uid' => $firebaseUid,
                    'provider' => 'google',
                    'role' => 'user',
                    'status' => 'aktif',
                    'password' => Hash::make(bin2hex(random_bytes(16))),
                ]);
            } else {
                // Update data jika perlu
                $user->update([
                    'nama' => $nama,
                    'firebase_uid' => $firebaseUid,
                    'provider' => 'google',
                ]);
            }

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => true,
                'message' => 'Login Google berhasil',
                'token' => $token,
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Social login gagal: ' . $e->getMessage(),
            ], 500);
        }
    }

    // PROFILE
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

    // UPDATE PROFILE
    public function updateProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'sometimes|required|string|max:100',
                'no_telp' => 'sometimes|nullable|string|max:20',
                'alamat' => 'sometimes|nullable|string|max:255',
                'pekerjaan' => 'sometimes|nullable|string|max:100',
                'gaji_per_bulan' => 'sometimes|nullable|integer|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = auth()->user();

            // Update hanya field yang dikirim
            if ($request->has('nama')) {
                $user->nama = $request->nama;
            }
            if ($request->has('no_telp')) {
                $user->no_telp = $request->no_telp;
            }
            if ($request->has('alamat')) {
                $user->alamat = $request->alamat;
            }
            if ($request->has('pekerjaan')) {
                $user->pekerjaan = $request->pekerjaan;
            }
            if ($request->has('gaji_per_bulan')) {
                $user->gaji_per_bulan = $request->gaji_per_bulan;
            }

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Profile berhasil diupdate',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Update profile gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    // LOGOUT
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
