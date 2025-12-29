@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg border-0" style="width: 400px; border-radius: 15px; background: #fffdf8;">
        <div class="card-body p-4">
            <h3 class="text-center mb-4" style="color: #2b2b2b; font-weight: 600;">Masuk ke Akun</h3>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            {{-- Alert Error --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold" style="color: #444;">Email</label>
                    <input id="email" type="email" name="email" class="form-control form-control-lg border-0 shadow-sm" 
                           placeholder="contoh@email.com" required autofocus 
                           style="background-color: #fff8e1;">
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold" style="color: #444;">Password</label>
                    <input id="password" type="password" name="password" class="form-control form-control-lg border-0 shadow-sm" 
                           placeholder="••••••••" required 
                           style="background-color: #fff8e1;">
                </div>

                {{-- Remember Me --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="remember" name="remember">
                    <label class="form-check-label small text-muted" for="remember">
                        Ingat saya
                    </label>
                </div>

                {{-- Forgot Password --}}
                @if (Route::has('password.request'))
                    <div class="text-end mb-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none" 
                           style="color: #f5b700; font-weight: 500;">
                            Lupa password?
                        </a>
                    </div>
                @endif

                {{-- Tombol Login --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-lg fw-semibold" 
                            style="background: linear-gradient(135deg, #f5b700, #ffcc33); border: none; color: #2b2b2b; border-radius: 30px; transition: 0.3s;">
                        Masuk
                    </button>
                </div>

                {{-- Link ke Register --}}
                <div class="text-center mt-3">
                    <span class="text-muted">Belum punya akun?</span>
                    <a href="/register" class="fw-semibold" style="color: #f5b700; text-decoration: none;"> Daftar Sekarang</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn:hover {
        filter: brightness(1.1);
        transform: translateY(-2px);
    }
    input:focus {
        outline: none !important;
        box-shadow: 0 0 0 0.25rem rgba(245,183,0,0.25);
    }
</style>
@endsection
