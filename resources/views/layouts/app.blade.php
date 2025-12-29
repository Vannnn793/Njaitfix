<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', "Who’s Tailors") }}</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

<style>
/* ============================== */
/*         GLOBAL SETTING         */
/* ============================== */

body {
    font-family: 'Poppins', sans-serif;
    background-color: #FFF4D4; /* soft cream modern */
    color: #4C461F;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

* {
    border-radius: 0;
    box-sizing: border-box;
}

/* ============================== */
/*             TOPBAR             */
/* ============================== */

.topbar {
    background: #FFD54A; /* golden modern */
    padding: 8px 0;
    color: #4C461F;
    font-size: .85rem;
    border-bottom: 1px solid #E7C23F;
}

/* ============================== */
/*             NAVBAR             */
/* ============================== */

.navbar-custom {
    background: #FFB800; /* honey warm untuk vibe modern */
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    padding: 10px 0;
    border-radius: 0 0 18px 18px;
}

.navbar-brand {
    font-family: 'Playfair Display', serif;
    font-weight: 600;
    color: #4C461F !important;
    display: flex;
    align-items: center;
}

.navbar-brand img {
    width: 38px;
    height: 38px;
    border-radius: 12px;
}

.navbar-toggler {
    border-radius: 12px;
}

.navbar-toggler-icon {
    filter: brightness(0) saturate(0);
}

/* ============================== */
/*           BUTTON AKUN          */
/* ============================== */

.btn-login {
    border: 2px solid #4C461F;
    color: #4C461F;
    background: transparent;
    border-radius: 30px;
    font-weight: 600;
    padding: 7px 20px;
    transition: .3s ease;
}

.btn-login:hover {
    background: #4C461F;
    color: #FFF4D4;
}

/* ============================== */
/*           DROPDOWN             */
/* ============================== */

.dropdown-menu {
    border-radius: 16px;
    padding: 6px 0;
    background: #FFF4D4;
}

.dropdown-item {
    border-radius: 10px;
    margin: 3px 8px;
    color: #4C461F;
}

.dropdown-item:hover {
    background: #FFD54A; /* soft yellow */
}

/* ============================== */
/*         HEADER / HERO          */
/* ============================== */

header {
    background: linear-gradient(135deg, #FFD54A, #FFB800); 
    color: #4C461F;
    padding: 50px 0;
    border-radius: 0 0 20px 20px;
}

header h1 {
    font-size: 2.3rem;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
}

.btn-light {
    background: #fff;
    color: #4C461F;
    border-radius: 30px;
    padding: 10px 22px;
    font-weight: 600;
}

.btn-light:hover {
    background: #4C461F;
    color: #fff;
}

/* ============================== */
/*              CARDS             */
/* ============================== */

.card-material {
    border: none;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 4px 10px rgba(76,70,31,0.2);
    transition: .3s ease;
}

.card-material:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(76,70,31,0.25);
}

.card-material img {
    height: 220px;
    object-fit: cover;
    border-radius: 18px 18px 0 0;
}

/* ============================== */
/*             FOOTER             */
/* ============================== */

footer {
    background: #4C461F; /* deep olive modern */
    color: #FFF4D4;
    padding: 20px 0;
    margin-top: auto;
    text-align: center;
    font-weight: 600;
    border-radius: 20px 20px 0 0;
}

/* ============================== */
/*            RESPONSIVE          */
/* ============================== */

@media (max-width: 768px) {
    .topbar {
        text-align: center;
    }
    .navbar-nav {
        text-align: center;
        gap: 10px;
    }
    .btn-login {
        width: 90%;
        margin: 0 auto;
    }
}

</style>
</head>

<body>

<!-- TOPBAR -->
{{-- <div class="topbar">
    <div class="container d-md-flex justify-content-between align-items-center">
      <div>✨ Penjahit Terpercaya</div>
      <div>
        <i class="bi bi-envelope"></i> {{ Auth::user()->email ?? "info@whostailors.com" }} |
        <i class="bi bi-person"></i> {{ Auth::user()->name ?? "Tamu" }}
      </div>
    </div>
</div> --}}

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
      <a class="navbar-brand" href="{{ route('login') }}">
        <img src="{{ asset('asset/image.png') }}" alt="Logo"> N’Jait
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">

          <!-- Dropdown akun -->
          <li class="nav-item dropdown ms-2">
            <button class="btn btn-login dropdown-toggle" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle me-1"></i> Akun
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow">
              <li><a class="dropdown-item" href="/login"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk</a></li>
              <li><a class="dropdown-item" href="/register"><i class="bi bi-person-plus me-2"></i>Daftar</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
</nav>

<!-- MAIN -->
<main class="py-4">
    <div class="container">@yield('content')</div>
</main>

<!-- FOOTER -->
<footer>
  © 2025 Who’s Tailors — Elegance in Every Stitch
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
