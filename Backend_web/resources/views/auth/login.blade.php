@extends('layouts.guest')

@section('title', 'Masuk — SimulasiMotor')

@section('content')

<div class="auth-wrap">

    {{-- ── PANEL KIRI (Visual) ── --}}
    <div class="auth-visual">
        <div class="auth-visual-grid"></div>
        <div class="auth-visual-content">

            {{-- Logo --}}
            <div class="auth-brand">
                <div class="lp-logo-mark" style="width:42px;height:42px;font-size:26px">H</div>
                <span class="auth-brand-name">SimulasiMotor</span>
            </div>

            <h2>Selamat<br>Datang<br><span>Admin</span></h2>
            <p>Masuk untuk mengelola data simulasi cicilan, tenor, dan rekomendasi motor Honda.</p>

            {{-- Feature list --}}
            <div class="auth-feature-list">
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="#fff"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Kelola rekomendasi tenor peminjaman
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="#fff"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Pantau data simulasi pengguna
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="#fff"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Akses panel manajemen motor Honda
                </div>
            </div>

        </div>
    </div>

    {{-- ── PANEL KANAN (Form) ── --}}
    <div class="auth-form-wrap">
        <div class="auth-form-box">

            {{-- Logo kecil --}}
            <div class="auth-logo">
                <div class="logo-mark">H</div>
                <span class="logo-name">SimulasiMotor</span>
            </div>

            <h1>Masuk</h1>
            <p class="auth-sub">Masukkan email dan kata sandi Anda</p>

            {{-- Error session --}}
            @if ($errors->any())
                <div class="auth-alert auth-alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input
                        id="email"
                        name="email"
                        class="form-control @error('email') is-error @enderror"
                        type="email"
                        placeholder="contoh@email.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    />
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input
                        id="password"
                        name="password"
                        class="form-control @error('password') is-error @enderror"
                        type="password"
                        placeholder="Masukkan kata sandi"
                        required
                    />
                </div>

                <div class="auth-row-check">
                    <label class="check-label">
                        <input type="checkbox" name="remember" style="accent-color:var(--red)"/>
                        Ingat saya
                    </label>
                    {{-- Uncomment jika sudah ada fitur lupa sandi --}}
                    {{-- <a href="{{ route('password.request') }}" class="auth-forgot">Lupa kata sandi?</a> --}}
                    <a href="#" class="auth-forgot">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="btn btn-red btn-full">
                    Masuk ke Dashboard
                </button>
            </form>

            <p class="auth-back">
                <a href="{{ route('landing') }}">← Kembali ke halaman utama</a>
            </p>

        </div>
    </div>

</div>

@endsection