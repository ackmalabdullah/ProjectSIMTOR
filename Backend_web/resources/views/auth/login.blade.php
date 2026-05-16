@extends('layouts.guest')

@section('title', 'Masuk — SimulasiMotor')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Barlow+Condensed:wght@700;800;900&display=swap');

:root {
    --red:       #CC0000;
    --red-dark:  #A00000;
    --red-glow:  rgba(204,0,0,0.12);
    --white:     #FFFFFF;
    --gray-100:  #F5F5F5;
    --gray-200:  #E0E0E0;
    --gray-400:  #AAAAAA;
    --gray-600:  #666666;
    --dark:      #1A1A1A;
    --font-head: 'Barlow Condensed', sans-serif;
    --font-body: 'Poppins', sans-serif;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: var(--font-body);
    background: var(--gray-100);
    min-height: 100vh;
    display: flex; align-items: center; justify-content: center;
    padding: 1.5rem;
}
a { text-decoration: none; color: inherit; }

/* ─── LAYOUT ─── */
.auth-wrap {
    display: grid; grid-template-columns: 1fr 1fr;
    width: 100%; max-width: 960px;
    background: var(--white); border-radius: 20px; overflow: hidden;
    box-shadow: 0 24px 80px rgba(0,0,0,0.12);
    min-height: 580px;
}

/* ─── LEFT PANEL (Visual) ─── */
.auth-visual {
    background: linear-gradient(155deg, var(--red) 0%, var(--red-dark) 100%);
    position: relative; overflow: hidden;
    padding: 3rem 2.5rem;
    display: flex; flex-direction: column; justify-content: space-between;
    color: white;
}
/* Grid overlay */
.auth-visual-grid {
    position: absolute; inset: 0; pointer-events: none;
    background-image:
        linear-gradient(rgba(255,255,255,0.07) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.07) 1px, transparent 1px);
    background-size: 38px 38px;
}
.auth-visual-grid::after {
    content: ''; position: absolute;
    bottom: -80px; right: -80px;
    width: 320px; height: 320px; border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.auth-visual-content { position: relative; z-index: 1; }

/* ─── Logo area ─── */
.auth-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 3rem; }
.lp-logo-mark {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-head); font-weight: 900; color: white;
}
.auth-brand-name {
    font-family: var(--font-head); font-size: 22px; font-weight: 800; letter-spacing: -.3px;
}

.auth-visual-content h2 {
    font-family: var(--font-head);
    font-size: 52px; font-weight: 900; line-height: .92;
    letter-spacing: -1px; text-transform: uppercase; margin-bottom: 1rem;
}
.auth-visual-content h2 span { opacity: .6; }
.auth-visual-content p {
    font-size: 14px; line-height: 1.7; opacity: .82; max-width: 280px; margin-bottom: 2rem;
}
.auth-feature-list { display: flex; flex-direction: column; gap: 12px; }
.auth-feature-item { display: flex; align-items: center; gap: 12px; font-size: 13.5px; font-weight: 500; }
.auth-feature-dot {
    width: 26px; height: 26px; flex-shrink: 0;
    background: rgba(255,255,255,0.18); border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
}
.auth-feature-dot svg { width: 12px; height: 12px; fill: none; stroke: white; stroke-width: 3; }

/* ─── RIGHT PANEL (Form) ─── */
.auth-form-wrap {
    display: flex; align-items: center; justify-content: center;
    padding: 3rem 2.5rem; background: var(--white);
}
.auth-form-box { width: 100%; max-width: 380px; }

/* Small logo */
.auth-logo {
    display: flex; align-items: center; gap: 8px; margin-bottom: 2.5rem;
}
.logo-mark {
    width: 36px; height: 36px; border-radius: 9px;
    background: var(--red);
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-head); font-size: 20px; font-weight: 900; color: white;
    box-shadow: 0 3px 10px rgba(204,0,0,0.28);
}
.logo-name { font-family: var(--font-head); font-size: 20px; font-weight: 800; color: var(--dark); letter-spacing: -.3px; }

.auth-form-box h1 {
    font-family: var(--font-head); font-size: 38px; font-weight: 900;
    text-transform: uppercase; letter-spacing: -.5px;
    color: var(--dark); margin-bottom: .3rem;
}
.auth-sub { font-size: 14px; color: var(--gray-400); margin-bottom: 1.8rem; }

/* Alert */
.auth-alert { padding: 12px 16px; border-radius: 10px; font-size: 13.5px; font-weight: 500; margin-bottom: 1.2rem; }
.auth-alert-error {
    background: rgba(204,0,0,0.07);
    border: 1px solid rgba(204,0,0,0.22);
    color: var(--red);
}

/* Form */
.form-group { margin-bottom: 1.1rem; }
.form-group label { display: block; font-size: 13px; font-weight: 600; color: var(--gray-600); margin-bottom: 6px; }
.form-control {
    width: 100%; padding: 12px 14px;
    border: 1.5px solid var(--gray-200); border-radius: 9px;
    font-family: var(--font-body); font-size: 14px; color: var(--dark);
    background: var(--white); transition: border-color .2s, box-shadow .2s; outline: none;
}
.form-control::placeholder { color: var(--gray-400); }
.form-control:focus { border-color: var(--red); box-shadow: 0 0 0 3px var(--red-glow); }
.form-control.is-error { border-color: var(--red); }

.auth-row-check { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.4rem; }
.check-label { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--gray-600); cursor: pointer; }
.auth-forgot { font-size: 13px; font-weight: 500; color: var(--red); transition: opacity .2s; }
.auth-forgot:hover { opacity: .75; }

/* Submit button */
.btn.btn-red.btn-full {
    width: 100%; padding: 14px;
    font-size: 15px; font-weight: 700; letter-spacing: .01em;
    border-radius: 10px;
    box-shadow: 0 6px 22px rgba(204,0,0,0.32);
    background: var(--red); color: white; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-body); transition: all .2s;
}
.btn.btn-red.btn-full:hover { background: var(--red-dark); transform: translateY(-1px); box-shadow: 0 8px 28px rgba(204,0,0,0.4); }

.auth-back { text-align: center; margin-top: 1.5rem; font-size: 13px; color: var(--gray-400); }
.auth-back a { color: var(--red); font-weight: 500; }
.auth-back a:hover { text-decoration: underline; }

/* Responsive */
@media (max-width: 680px) {
    .auth-wrap { grid-template-columns: 1fr; }
    .auth-visual { display: none; }
    .auth-form-wrap { padding: 2.5rem 1.5rem; }
}
</style>

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
                        <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Kelola rekomendasi tenor peminjaman
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Pantau data simulasi pengguna
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
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