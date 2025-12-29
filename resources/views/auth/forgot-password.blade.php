@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg border-0" style="width: 420px; border-radius: 15px; background: #fffdf8;">
        <div class="card-body p-4">
            <h3 class="text-center mb-3" style="color: #2b2b2b; font-weight: 600;">Lupa Password?</h3>
            <p class="text-center text-muted mb-4" style="font-size: 0.9rem;">
                Tenang aja — masukin email kamu, nanti kami kirim link untuk reset password.
            </p>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert alert-success text-center">{{ session('status') }}</div>
            @endif

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Email Input --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold" style="color: #444;">Alamat Email</label>
                    <input id="email" type="email" name="email"
                        class="form-control form-control-lg border-0 shadow-sm"
                        style="background-color: #fff8e1;" placeholder="contoh@email.com"
                        value="{{ old('email') }}" required autofocus>
                </div>

                {{-- Submit Button --}}
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg fw-semibold"
                        style="background: linear-gradient(135deg, #f5b700, #ffcc33); border: none; color: #2b2b2b; border-radius: 30px; transition: 0.3s;">
                        Kirim Link Reset Password
                    </button>
                </div>

                {{-- Back to Login --}}
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="fw-semibold" style="color: #f5b700; text-decoration: none;">
                        Kembali ke Halaman Login
                    </a>
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
        box-shadow: 0 0 0 0.25rem rgba(245, 183, 0, 0.25);
    }
</style>
@endsection
