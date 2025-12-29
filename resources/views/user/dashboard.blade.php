@extends('layouts.cust')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-gradient">
            <i class="bi bi-scissors"></i> Desain Tersedia
        </h2>
        <p class="text-muted fs-5">Temukan inspirasi dari para penjahit terbaik ✨</p>
    </div>

    <div class="row g-4 justify-content-center">
        @forelse ($photos as $photo)
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <a href="{{ route('user.tailor-detail', $photo->user->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 rounded-4 shadow-sm hover-card">
                        <div class="card-img-wrapper">
                            <img src="{{ asset('storage/' . $photo->path) }}"
                                 class="card-img-top rounded-top-4"
                                 alt="Foto Etalase">
                            <div class="overlay d-flex justify-content-center align-items-center">
                                <span class="text-dark bg-light px-3 py-1 rounded-pill small fw-semibold">
                                    Lihat Detail
                                </span>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-dark text-truncate mb-1">
                                <i class="bi bi-person-circle me-1 text-warning"></i> {{ $photo->user->name ?? 'Penjahit' }}
                            </h6>
                            <p class="text-muted small mb-2 text-truncate">
                                {{ $photo->user->tailor->deskripsi ?? 'Belum ada deskripsi.' }}
                            </p>
                            @if(isset($photo->user->tailor->harga))
                                <p class="fw-bold text-warning mb-0">
                                    Rp {{ number_format($photo->user->tailor->harga, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center mt-5">
                <i class="bi bi-box text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-2">Belum ada desain tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
/* ======== Modern Card Style ======== */
.text-gradient {
    background: linear-gradient(90deg, #f5b700, #ffda44);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.card {
    background: #fffdf5;
    border-radius: 18px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.card-img-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 16px 16px 0 0;
}

.card-img-top {
    width: 100%;
    height: 180px;
    object-fit: cover;
    transition: transform 0.4s ease, filter 0.4s ease;
    border-radius: 16px 16px 0 0;
}

.card-body {
    padding: 12px;
}

.card:hover .card-img-top {
    transform: scale(1.07);
    filter: brightness(0.9);
}

/* ======== Hover & Overlay ======== */
.hover-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(245, 183, 0, 0.25);
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    opacity: 0;
    background: rgba(255, 243, 200, 0.5);
    transition: 0.3s ease;
    backdrop-filter: blur(2px);
    border-radius: 16px 16px 0 0;
}

.card-img-wrapper:hover .overlay {
    opacity: 1;
}

/* ======== Responsiveness ======== */
@media (max-width: 576px) {
    .card-img-top {
        height: 150px;
    }
}
</style>
@endsection
