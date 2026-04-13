<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── TAMPILKAN FORM LOGIN ─────────────────────────────
    public function loginForm()
    {
        return view('auth.login');
    }

    // ── PROSES LOGIN ────────────────────────────────────
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // TODO: ganti route tujuan setelah login tersedia
            return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau kata sandi tidak sesuai.'])
            ->onlyInput('email');
    }

    // ── TAMPILKAN FORM REGISTER ─────────────────────────
    public function registerForm()
    {
        return view('auth.register');
    }

    // ── PROSES REGISTER ─────────────────────────────────
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'password'   => ['required', 'confirmed', Password::min(8)],
            'agree_tos'  => ['accepted'],
        ], [
            'email.unique'    => 'Email ini sudah terdaftar.',
            'agree_tos.accepted' => 'Anda harus menyetujui syarat & ketentuan.',
        ]);

        $user = User::create([
            'name'     => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        // TODO: ganti route tujuan setelah dashboard tersedia
        return redirect('/dashboard');
    }

    // ── LOGOUT ──────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}