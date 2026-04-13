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

            <h2>Selamat<br>Datang<br><span>Kembali</span></h2>
            <p>Masuk ke akun Anda untuk mengakses simulasi cicilan dan histori lengkap Anda.</p>

            {{-- Feature list --}}
            <div class="auth-feature-list">
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="#fff"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Rekomendasi cicilan personal
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="#fff"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Simpan & bandingkan simulasi
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="#fff"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Akses 50+ model Honda terbaru
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

            <div class="auth-divider">atau</div>

            {{-- Google (siapkan jika pakai Socialite) --}}
            <button class="btn btn-gray btn-full" disabled title="Segera hadir">
                <svg width="16" height="16" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Masuk dengan Google
            </button>

            <p class="auth-switch">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>
            <p class="auth-back">
                <a href="{{ route('landing') }}">← Kembali ke halaman utama</a>
            </p>

        </div>
    </div>

</div>

@endsection