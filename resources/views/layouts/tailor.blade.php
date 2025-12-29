<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'N’Jait') }} - Customer</title>

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- JS Auth Info untuk Echo/Pusher --}}
    <script>
        window.Laravel = { userId: {{ Auth::id() ?? 'null' }} };
    </script>

    <style>
:root {
    --yellow-main: #FFC736;
    --yellow-soft: #FFE8A3;
    --yellow-hover: #FFD769;
    --text-dark: #3C3822;
    --bg-cream: #FFF5DB;
    --radius-soft: 18px;
}

/* BASIC */
body {
    background-color: var(--bg-cream);
    font-family: 'Poppins', sans-serif;
    color: var(--text-dark);
}

* {
    border-radius: var(--radius-soft) !important;
    box-sizing: border-box;
}

/* TOPBAR */
.topbar {
    background: linear-gradient(90deg, #FFEAA9, #FFD86A);
    padding: 6px 0;
    border-bottom: 1px solid #E5C45A;
    font-size: 0.85rem;
    border-radius: 0 0 var(--radius-soft) var(--radius-soft) !important;
}

/* NAVBAR */
.navbar-custom {
    background: var(--yellow-main);
    box-shadow: 0 3px 12px rgba(0,0,0,0.15);
    border-radius: 0 0 var(--radius-soft) var(--radius-soft) !important;
    padding: 12px 0;
}

.navbar-brand {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--text-dark) !important;
    display: flex;
    align-items: center;
    gap: 8px;
    border-radius: 0 !important;
}

/* SEARCH BAR */
.search-bar {
    position: relative;
}

.search-bar input {
    padding-left: 42px;
    height: 44px;
    border: 1px solid #D1B456;
    background: #FFF8E3;
}

.search-bar i {
    position: absolute;
    top: 50%;
    left: 14px;
    transform: translateY(-50%);
    color: #8B6A00;
}

/* NAV LINKS */
.nav-link {
    font-weight: 600;
    color: var(--text-dark) !important;
    padding: 8px 16px;
}

.nav-link:hover {
    background: var(--yellow-soft);
    color: #8B6A00 !important;
}

/* DROPDOWN */
.dropdown-menu {
    background: var(--bg-cream);
    border: none;
    padding: 12px;
    box-shadow: 0 4px 14px rgba(0,0,0,.12);
}

.dropdown-item {
    font-weight: 500;
}

.dropdown-item:hover {
    background: var(--yellow-soft);
}

/* PROFILE AVATAR */
.profile-btn img {
    width: 40px;
    height: 40px;
    border-radius: 50% !important;
    object-fit: cover;
    border: 2px solid #8B6A00;
}

/* HEADER */
header {
    background: linear-gradient(135deg, #FFC736, #FFD769);
    color: var(--text-dark);
    padding: 50px 0;
    text-align: center;
}

header h1 {
    font-size: 2.3rem;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
}

/* CARD MATERIAL */
.card-material {
    border: none;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    transition: .3s;
    overflow: hidden;
}

.card-material:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.17);
}

.card-material img {
    height: 220px;
    object-fit: cover;
    border-radius: var(--radius-soft) var(--radius-soft) 0 0 !important;
}

/* FOOTER */
footer {
    background: #4C461F;
    color: #FFF4D4;
    padding: 20px 0;
    text-align: center;
    font-weight: 600;
    border-radius: var(--radius-soft) var(--radius-soft) 0 0 !important;
    box-shadow: 0 -2px 6px rgba(0,0,0,0.15);
}

/* MOBILE FIX */
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

.photo-viewer {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1055;
}

.photo-viewer img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0,0,0,.5);
    animation: zoomIn .2s ease;
}

.close-btn {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 40px;
    color: #fff;
    cursor: pointer;
}

@keyframes zoomIn {
    from { transform: scale(.9); opacity: 0 }
    to   { transform: scale(1); opacity: 1 }
}


    </style>
</head>

<body>

    {{-- 🔝 Topbar
    <div class="topbar text-center text-md-start">
        <div class="container d-md-flex justify-content-between align-items-center">
            <div><i class="bi bi-star-fill text-warning"></i> Penjahit terpercaya</div>
            <div>
                @if(Auth::check())
                    <i class="bi bi-envelope"></i> {{ Auth::user()->email ?? '' }} |
                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name ?? '' }}
                @endif
            </div>
        </div>
    </div> --}}

    {{-- 🧭 Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-warning shadow-sm">
        <div class="container">
            <a class="navbar-brand text-dark fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-scissors"></i> MakeCloth
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse mt-2 mt-lg-0" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a href="{{ route('chatify') }}" class="nav-link text-dark fw-semibold">
                            <i class="bi bi-chat-dots"></i> Chat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.orders') }}" class="nav-link text-dark fw-semibold">
                            <i class="bi bi-receipt"></i> Pesanan
                        </a>
                    </li>

                    {{-- Profil Section --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 position-relative" href="#" id="userDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="position-relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&background=facc15&color=000"
                                     alt="avatar" class="rounded-circle shadow-sm border" width="36" height="36">
                                <span class="online-dot"></span>
                            </div>
                            <span class="fw-semibold">{{ Auth::user()->name ?? 'User' }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-3" aria-labelledby="userDropdown"
                            style="min-width: 250px;">
                            <li class="text-center mb-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&background=facc15&color=000"
                                     width="60" height="60" class="rounded-circle mb-2 shadow-sm border">
                                <div class="fw-bold">{{ Auth::user()->name ?? 'Guest' }}</div>
                                <small class="text-muted">{{ Auth::user()->email ?? '' }}</small>
                            </li>
                            <hr class="dropdown-divider">

                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item py-2 rounded-2">
                                    <i class="bi bi-person-lines-fill text-warning me-2"></i> Lihat Profil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('edit') }}" class="dropdown-item py-2 rounded-2">
                                    <i class="bi bi-pencil-square text-warning me-2"></i> Edit Profil
                                </a>
                            </li>
                            <hr class="dropdown-divider">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-flex justify-content-center">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100 fw-semibold rounded-3">
                                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- 💡 Konten --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- 🦶 Footer --}}
    <footer class="text-center py-3 mt-5">
        <small>&copy; {{ date('Y') }} <strong>N’Jait</strong> — Semua Hak Dilindungi</small>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Optional: Notif --}}
    <div id="notif-container"></div>

    <script>
        function showNotif(title, message) {
            const notif = document.createElement('div');
            notif.classList.add('notif-toast');
            notif.innerHTML = `<strong>${title}</strong><br>${message}`;
            document.body.appendChild(notif);
            setTimeout(() => notif.remove(), 5000);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>

<script>
import Echo from 'laravel-echo';
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: "{{ config('reverb.app_key') }}",
    wsHost: "{{ config('reverb.host') ?? 'localhost' }}",
    wsPort: {{ config('reverb.port') ?? 8080 }},
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});
window.Echo.channel('admin.notifications')
    .listen('.payment.status.updated', (e) => {
        showNotif("Pembayaran Diterima", e.message);
    });
</script>

</body>
</html>
