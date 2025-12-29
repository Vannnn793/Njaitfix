@extends('layouts.app') {{-- Pastikan layout utama kamu bernama layouts.app --}}

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #fff8e1;">
    <div class="card shadow-lg border-0 p-4" style="max-width: 450px; width: 100%; border-radius: 15px;">
        <div class="text-center mb-3">
            <h3 class="fw-bold text-warning">Daftar Akun Baru</h3>
            <p class="text-muted">Bergabung sebagai pelanggan atau penjahit</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama kamu">
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com">
            </div>

            {{-- Role --}}
            <div class="mb-3">
                <label for="role" class="form-label fw-semibold">Daftar Sebagai</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="tailor" {{ old('role') == 'tailor' ? 'selected' : '' }}>Tailor (Penjahit)</option>
                </select>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input id="password" type="password" class="form-control" name="password" required placeholder="Masukkan password">
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Ulangi password">
            </div>

            {{-- Tombol --}}
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-warning text-white fw-bold" style="background-color: #f7b500; border: none;">
                    Daftar Sekarang
                </button>
            </div>

            <div class="text-center">
                <p class="mb-0">Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-warning">Masuk di sini</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
