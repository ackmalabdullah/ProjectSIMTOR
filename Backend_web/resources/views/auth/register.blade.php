@extends('layouts.guest')

@section('title', 'Daftar — SimulasiMotor')

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

            <h2>Bergabung<br><span>Bersama</span><br>Kami</h2>
            <p>Daftarkan diri Anda dan mulai merencanakan kepemilikan motor Honda impian Anda hari ini.</p>

            {{-- Stats kecil --}}
            <div class="auth-feature-list" style="margin-top:2.5rem">
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="#fff"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Gratis selamanya
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="#fff"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Daftar kurang dari 1 menit
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-dot">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="#fff"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    Langsung akses semua fitur
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

            <h1>Daftar</h1>
            <p class="auth-sub">Buat akun baru — gratis selamanya</p>

            {{-- Error session --}}
            @if ($errors->any())
                <div class="auth-alert auth-alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nama --}}
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="first_name">Nama Depan</label>
                        <input
                            id="first_name"
                            name="first_name"
                            class="form-control @error('first_name') is-error @enderror"
                            placeholder="Budi"
                            value="{{ old('first_name') }}"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nama Belakang</label>
                        <input
                            id="last_name"
                            name="last_name"
                            class="form-control @error('last_name') is-error @enderror"
                            placeholder="Santoso"
                            value="{{ old('last_name') }}"
                            required
                        />
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input
                        id="email"
                        name="email"
                        class="form-control @error('email') is-error @enderror"
                        type="email"
                        placeholder="budi@email.com"
                        value="{{ old('email') }}"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="phone">Nomor HP</label>
                    <input
                        id="phone"
                        name="phone"
                        class="form-control @error('phone') is-error @enderror"
                        type="tel"
                        placeholder="08xx-xxxx-xxxx"
                        value="{{ old('phone') }}"
                    />
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input
                        id="password"
                        name="password"
                        class="form-control @error('password') is-error @enderror"
                        type="password"
                        placeholder="Min. 8 karakter"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        type="password"
                        placeholder="Ulangi kata sandi"
                        required
                    />
                </div>

                {{-- Checkbox persetujuan --}}
                <label class="check-label check-label-tos">
                    <input type="checkbox" name="agree_tos" style="accent-color:var(--red);margin-top:2px" required/>
                    Saya menyetujui
                    <a href="#" class="link-red">Syarat & Ketentuan</a>
                    dan
                    <a href="#" class="link-red">Kebijakan Privasi</a>
                </label>

                <button type="submit" class="btn btn-red btn-full">
                    Buat Akun
                </button>
            </form>

            <p class="auth-switch">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </p>
            <p class="auth-back">
                <a href="{{ route('landing') }}">← Kembali ke halaman utama</a>
            </p>

        </div>
    </div>

</div>

@endsection