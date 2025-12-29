@extends('layouts.cust')

@section('content')
<div class="container py-5">

    {{-- Tombol Kembali --}}
    <a href="{{ url('/user/dashboard') }}" class="btn btn-outline-dark rounded-pill mb-4 px-4 py-2 shadow-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="row g-5">
        {{-- Kolom Kiri: Gambar --}}
        <div class="col-lg-5">
            <div class="main-photo mb-4 position-relative">
                @if($selectedPhoto)
                    <img src="{{ asset('storage/' . $selectedPhoto->path) }}" class="img-fluid rounded-4 shadow" alt="Foto Etalase">
                @elseif($photos->isNotEmpty())
                    <img src="{{ asset('storage/' . $photos->first()->path) }}" class="img-fluid rounded-4 shadow" alt="Foto Etalase">
                @else
                    <img src="{{ asset('images/no-photo.png') }}" class="img-fluid rounded-4 shadow" alt="Tidak ada foto">
                @endif
            </div>

            @php
                $displayPhoto = $selectedPhoto ?? $photos->first();
            @endphp

            @if($displayPhoto && $displayPhoto->extra_price)
                <div class="text-center mb-4">
                    <h6 class="fw-semibold text-dark">Harga Bahan Tambahan</h6>
                    <h4 class="text-warning fw-bold mb-0">Rp {{ number_format($displayPhoto->extra_price, 0, ',', '.') }}</h4>
                </div>
            @endif

            {{-- Galeri foto lainnya --}}
            <div class="gallery d-flex flex-wrap gap-2 justify-content-center">
                @foreach($photos as $photo)
                    <a href="{{ route('user.tailor-detail', ['userId' => $tailor->user_id, 'photo_id' => $photo->id]) }}">
                        <img src="{{ asset('storage/' . $photo->path) }}"
                             class="thumb-img {{ $selectedPhoto && $selectedPhoto->id === $photo->id ? 'active' : '' }}"
                             alt="Foto tambahan">
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Kolom Kanan: Detail --}}
        <div class="col-lg-7">
            <div class="tailor-info mb-4">
                <h3 class="fw-bold mb-1">{{ $tailor->user->name }}</h3>
                <p class="text-muted fs-6 mb-3">{{ $tailor->skill ?? 'Spesialisasi tidak tersedia' }}</p>
                <p class="text-secondary mb-3">{{ $tailor->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                <div class="d-flex flex-column mb-3 small">
                    <span><i class="bi bi-geo-alt text-warning me-2"></i>{{ $tailor->alamat ?? 'Belum ada alamat' }}</span>
                    <span><i class="bi bi-telephone text-warning me-2"></i>{{ $tailor->no_hp ?? '-' }}</span>
                </div>

                @if(isset($tailor->harga))
                    <h4 class="fw-bold text-warning mb-4">Rp {{ number_format($tailor->harga, 0, ',', '.') }}</h4>
                @endif

                <a href="{{ route('order.create', ['product_id' => $tailor->id, 'photo_id' => $selectedPhoto->id ?? null]) }}" 
                   class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-cart"></i> Pesan Sekarang
                </a>
            </div>

            {{-- Rating dan Ulasan --}}
            <div class="rating-section mt-5">
                @if($tailor->ratings->count() > 0)
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="fw-bold mb-0 me-2">⭐ {{ number_format($tailor->ratings->avg('rating'), 1) }}/5</h5>
                        <span class="text-muted small">({{ $tailor->ratings->count() }} ulasan)</span>
                    </div>
                @else
                    <p class="text-muted">Belum ada rating untuk penjahit ini.</p>
                @endif

                @if($tailor->ratings->count() > 0)
                    <div class="reviews mt-3">
                        @foreach($tailor->ratings as $rating)
                            <div class="review-card p-3 mb-4 rounded-4 shadow-sm bg-white">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $rating->user->name }}</strong>
                                        <span class="text-warning">({{ str_repeat('⭐', $rating->rating) }})</span>
                                        <p class="text-muted mb-2 mt-1">{{ $rating->comment ?? '-' }}</p>
                                    </div>
                                    <small class="text-muted">{{ $rating->created_at->format('d M Y') }}</small>
                                </div>

                                {{-- Foto review --}}
                                @if($rating->photo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $rating->photo_path) }}" 
                                             class="rounded-3 shadow-sm" 
                                             style="width: 120px; height: 120px; object-fit: cover;" 
                                             alt="Foto Review">
                                    </div>
                                @endif

                                {{-- Balasan Penjahit --}}
                                @php
                                    $reply = $rating->replies->where('user_id', $tailor->user_id)->first();
                                @endphp

                                <div class="reply-section mt-3 ps-3 border-start border-3 border-warning">
                                    @if($reply)
                                        <div class="d-flex justify-content-between">
                                            <strong class="text-primary">{{ $reply->user->name }}
                                                <span class="badge bg-warning text-dark ms-1">Penjahit</span>
                                            </strong>
                                            <small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }}</small>
                                        </div>
                                        <p class="mt-1 mb-2">{{ $reply->reply }}</p>

                                        {{-- Edit Balasan (kalau penjahit login) --}}
                                        @auth
                                            @if(auth()->user()->id === $tailor->user_id)
                                                <form action="{{ route('rating.reply.update', $reply->id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="reply" class="form-control form-control-sm mb-2" rows="2">{{ $reply->reply }}</textarea>
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">💬 Update Balasan</button>
                                                </form>
                                            @endif
                                        @endauth
                                    @else
                                        @auth
                                            @if(auth()->user()->id === $tailor->user_id)
                                                <form action="{{ route('rating.reply.store', $rating->id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <textarea name="reply" class="form-control form-control-sm mb-2" rows="2" placeholder="Balas komentar pelanggan..."></textarea>
                                                    <button type="submit" class="btn btn-sm btn-outline-warning">✉️ Kirim Balasan</button>
                                                </form>
                                            @endif
                                        @endauth
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Styling Modern --}}
<style>
.thumb-img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 10px;
    transition: all 0.3s ease;
}
.thumb-img:hover {
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(245, 183, 0, 0.4);
}
.thumb-img.active {
    border: 3px solid #f5b700;
}

.review-card {
    transition: 0.3s;
}
.review-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(245, 183, 0, 0.15);
}

.text-warning {
    color: #f5b700 !important;
}

.btn-warning:hover {
    background-color: #ffcd38 !important;
    color: #2b2b2b !important;
}
</style>
@endsection
