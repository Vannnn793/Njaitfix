<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'N’Jait') }} - Customer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --yellow-main: #FFC736;
        --yellow-soft: #FFE8A3;
        --yellow-hover: #FFD769;
        --text-dark: #3C3822;
        --bg-cream: #FFF5DB;
        --radius-soft: 18px;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--bg-cream);
        color: var(--text-dark);
        margin: 0;
        padding: 0;
    }

    /* ------------------------ */
    /* HAPUS SUDUT RUNCING GLOBAL */
    /* ------------------------ */
    * {
        border-radius: var(--radius-soft) !important;
        box-sizing: border-box;
    }

    /* ------------------------ */
    /* TOPBAR */
    /* ------------------------ */
    .topbar {
        background: linear-gradient(90deg, #FFE9A8, #FFD86A);
        padding: 6px 0;
        border-bottom: 1px solid #E5C45A;
        border-radius: 0 0 var(--radius-soft) var(--radius-soft) !important;
        font-size: .85rem;
    }

    /* ------------------------ */
    /* NAVBAR */
    /* ------------------------ */
    .navbar-custom {
        background: var(--yellow-main);
        box-shadow: 0 3px 12px rgba(0,0,0,0.12);
        border-radius: 0 0 var(--radius-soft) var(--radius-soft) !important;
        padding: 10px 0;
    }

    .navbar-brand {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-dark) !important;
        display: flex;
        align-items: center;
        gap: 6px;
        border-radius: 0 !important;
    }

    /* SEARCH */
    .search-bar {
        position: relative;
    }

    .search-bar input {
        padding-left: 40px;
        background: #FFF9E8;
        border: 1px solid #D1B456;
        height: 42px;
    }

    .search-bar i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #8B6A00;
    }

    /* NAV LINKS */
    .nav-link {
        font-weight: 500;
        color: var(--text-dark) !important;
    }

    .nav-link:hover {
        color: #8B6A00 !important;
    }

    /* ------------------------ */
    /* DROPDOWN */
    /* ------------------------ */
    .dropdown-menu {
        background: var(--bg-cream);
        border: none;
        box-shadow: 0 4px 14px rgba(0,0,0,.1);
    }

    .dropdown-item:hover {
        background: var(--yellow-soft);
    }

    /* PROFILE IMAGE */
    .profile-btn img {
        width: 38px;
        height: 38px;
        object-fit: cover;
        border-radius: 50% !important;
        border: 2px solid #8B6A00;
    }

    /* ------------------------ */
    /* HEADER (dari style lama) */
    /* ------------------------ */
    header {
        background: linear-gradient(135deg, #FFC736, #FFD769);
        color: var(--text-dark);
        padding: 50px 0;
        text-align: center;
        border-radius: 0 0 var(--radius-soft) var(--radius-soft) !important;
    }

    header h1 {
        font-size: 2.3rem;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
    }

    .btn-light {
        background: #fff;
        color: var(--text-dark);
        font-weight: 600;
        padding: 10px 24px;
        transition: .3s ease;
        border-radius: 30px !important;
    }

    .btn-light:hover {
        background: var(--text-dark);
        color: #fff;
        transform: translateY(-2px);
    }

    /* ------------------------ */
    /* CARD MATERIAL (versi penuh) */
    /* ------------------------ */
    .card-material {
        border: none;
        background: #fff;
        border-radius: var(--radius-soft);
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        transition: 0.3s ease;
        overflow: hidden;
    }

    .card-material:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }

    .card-material img {
        height: 220px;
        object-fit: cover;
        border-radius: var(--radius-soft) var(--radius-soft) 0 0 !important;
    }

    /* ANIMASI SECTION */
    section {
        animation: fadeInUp .8s ease both;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ------------------------ */
    /* FOOTER */
    /* ------------------------ */
    footer {
        background: #4C461F;
        color: #FFF4D4;
        padding: 20px 0;
        text-align: center;
        font-weight: 600;
        margin-top: auto;
        border-radius: var(--radius-soft) var(--radius-soft) 0 0 !important;
        box-shadow: 0 -2px 6px rgba(0,0,0,0.1);
    }

    /* ------------------------ */
    /* RESPONSIVE FIX */
    /* ------------------------ */
    @media (max-width: 576px) {
        .topbar .container {
            text-align: center;
            flex-direction: column;
            gap: 6px;
        }
        .search-bar {
            width: 100%;
            margin-top: 10px;
        }
    }
</style>

</head>

<body class="d-flex flex-column min-vh-100">

    <!-- TOPBAR -->
    {{-- <div class="topbar">
        <div class="container d-flex justify-content-between">
            <div>🧵 Penjahit terpercaya</div>
            <div>
                <i class="bi bi-envelope"></i> {{ Auth::user()->email ?? "" }} |
                <i class="bi bi-person"></i> {{ Auth::user()->name ?? "" }}
            </div>
        </div>
    </div> --}}

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">

            <a class="navbar-brand" href="{{ url('user/welcome') }}">
                <i class="bi bi-scissors"></i> N’Jait
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <i class="bi bi-list fs-1"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">

                <!-- Search -->
                <form action="{{ route('tailor.search') }}" method="GET" class="ms-lg-auto me-lg-3 search-bar d-flex">
                    {{-- <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-4"> --}}
                            <div class="input-group">
                                <input
                                    type="text"
                                    name="q"
                                    class="form-control rounded-start-pill"
                                    placeholder="Cari penjahit atau deskripsi..."
                                    value="{{ request('q') }}"
                                >
                                <button class="btn btn-warning rounded-end-pill px-4" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        {{-- </div>
                    </div> --}}
                </form>

                <ul class="navbar-nav align-items-center gap-lg-2">

                    <li class="nav-item"><a class="nav-link" href="{{ route('user.welcome') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Pesanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('chatify') }}">Chat</a></li>

                    <!-- PROFILE -->
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="dropdown-toggle profile-btn" data-bs-toggle="dropdown" href="#">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=FFC736&color=3C3822">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end mt-2">
                            <li class="dropdown-header fw-semibold">
                                {{ Auth::user()->name }}
                            </li>
                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="text-center py-4 mt-auto">
        <small>&copy; {{ date('Y') }} N’Jait — Elegance in Every Stitch.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
