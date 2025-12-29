@extends('layouts.tailor')

@section('content')
<div class="container py-5 fade-in">

    {{-- 💡 DARK MODE TOGGLE
    <div class="d-flex justify-content-end mb-3">
        <button id="theme-toggle" class="btn btn-sm btn-outline-dark rounded-pill px-3">
            🌞 Light
        </button>
    </div> --}}

    {{-- ⭐ RATING SUMMARY --}}
    @if($tailor && $tailor->ratings->count() > 0)
        <div class="alert alert-light border-start border-warning border-4 shadow-sm mb-5">
            <h5 class="mb-0">
                ⭐ <strong>{{ number_format($tailor->ratings->avg('rating'), 1) }}/5</strong>
                dari <strong>{{ $tailor->ratings->count() }}</strong> ulasan pelanggan.
            </h5>
        </div>
    @endif

    {{-- 🧵 PROFIL PENJAHIT --}}
    <div class="text-center mb-5">
        <div class="position-relative d-inline-block">
            <div class="profile-frame shadow-lg p-1 bg-white">
                <img loading="lazy" src="{{ $tailor->user->pp ? asset('storage/' . $tailor->user->pp) : asset('default-avatar.png') }}"
                    alt="Foto Profil" class="rounded-circle" width="160" height="160" style="object-fit: cover;">
            </div>
        </div>

        <h2 class="mt-3 fw-bold text-dark">{{ $tailor->nama ?? 'Nama Penjahit' }}</h2>
        <p class="text-muted fs-5 mb-1">{{ $tailor->skill ?? 'Spesialisasi tidak tersedia' }}</p>
        <div class="d-flex flex-wrap justify-content-center gap-2 text-muted">
            <span><i class="bi bi-geo-alt text-warning"></i> {{ $tailor->alamat ?? 'Belum ada alamat' }}</span>
            <span><i class="bi bi-telephone text-warning"></i> {{ $tailor->no_hp ?? '-' }}</span>
        </div>
        <p class="fw-semibold mt-3 bg-warning bg-opacity-25 px-3 py-2 rounded d-inline-block">
            💸 Harga mulai: Rp {{ number_format($tailor->harga ?? 0, 0, ',', '.') }}
        </p>
        <p class="mt-3 text-secondary" style="max-width: 600px; margin: 0 auto;">
            {{ $tailor->deskripsi ?? 'Belum ada deskripsi.' }}
        </p>
    </div>

    {{-- 📸 FORM UPLOAD KARYA --}}
    <div class="card border-0 shadow-lg mb-5 rounded-4 overflow-hidden fade-in">
        <div class="card-header bg-warning bg-gradient text-dark fw-semibold d-flex align-items-center">
            <i class="bi bi-cloud-arrow-up me-2"></i> Tambah Karya Baru
        </div>
        <div class="card-body bg-light">
            <form id="uploadForm" method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="photo" class="form-label fw-semibold">Pilih Foto Karya</label>
                    <input type="file" name="photo[]" id="photo" class="form-control border-warning" multiple required>
                </div>
                <div class="mb-3">
                    <label for="extra_price" class="form-label fw-semibold">Tambahan Harga (Rp)</label>
                    <input type="number" name="extra_price" id="extra_price" class="form-control border-warning" placeholder="Contoh: 50000">
                    <small class="text-muted">Kosongkan jika tidak ada tambahan biaya.</small>
                </div>
                <button type="submit" class="btn btn-warning text-dark fw-semibold shadow-sm w-100">
                    <i class="bi bi-upload"></i> Upload Karya
                </button>
            </form>
        </div>
    </div>

    {{-- 🖼️ GALERI KARYA --}}
    <h3 class="text-center fw-bold text-dark mb-4"><i class="bi bi-images"></i> Karya Saya</h3>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 fade-in">
        @forelse($tailor_photos as $photo)
            <div class="col">
                <div class="card border-0 shadow-sm hover-card position-relative overflow-hidden">
                    <img loading="lazy" src="{{ asset('storage/' . $photo->path) }}" alt="Karya" class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="photo-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <button class="btn btn-outline-light btn-sm me-2"
                                onclick="openViewer('{{ asset('storage/' . $photo->path) }}')">
                            <i class="bi bi-eye-fill"></i>
                        </button>

                        <form action="{{ route('destroy', $photo->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus foto ini?')"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted mt-4">Belum ada karya yang ditampilkan.</p>
        @endforelse
    </div>
<div id="photoViewer" class="photo-viewer d-none">
    <span class="close-btn" onclick="closeViewer()">&times;</span>
    <img id="viewerImage" src="" alt="Preview">
</div>

    {{-- 💬 KOMENTAR --}}
    <hr class="my-5">
    <h4 class="fw-bold text-dark mb-4">💬 Ulasan Pelanggan</h4>

    @forelse($tailor->ratings as $rating)
        <div class="border rounded-4 p-4 mb-3 shadow-sm bg-white fade-in">
            <div class="d-flex justify-content-between align-items-center">
                <strong>{{ $rating->user->name }}</strong>
                <span class="text-warning">{{ str_repeat('⭐', $rating->rating) }}</span>
            </div>
            <p class="mb-1 text-muted">{{ $rating->comment ?? 'Tidak ada komentar.' }}</p>
            <small class="text-muted">🕒 {{ $rating->created_at->format('d M Y, H:i') }}</small>

            @if($rating->photo_path)
                <div class="mt-3">
                    <img loading="lazy" src="{{ asset('storage/' . $rating->photo_path) }}" class="rounded shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                </div>
            @endif

            @if($rating->replies->count() > 0)
                <div class="bg-light border-start ps-3 py-2 mt-3 rounded-3">
                    @foreach($rating->replies as $reply)
                        <div class="mb-2">
                            <strong class="text-primary">{{ $reply->user->name }}</strong>: {{ $reply->reply }}
                            <br><small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }}</small>
                            @if(Auth::id() === $reply->user_id)
                                <button class="btn btn-link btn-sm text-primary p-0 ms-2" data-bs-toggle="collapse" data-bs-target="#editReply{{ $reply->id }}">✏️ Edit</button>
                                <div class="collapse mt-2" id="editReply{{ $reply->id }}">
                                    <form action="{{ route('rating.reply.update', $reply->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <textarea name="reply" class="form-control mb-2" rows="2">{{ $reply->reply }}</textarea>
                                        <button type="submit" class="btn btn-sm btn-warning text-dark">Simpan</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            @if(Auth::check() && Auth::user()->role === 'tailor')
                @php $hasReplied = $rating->replies->where('user_id', Auth::id())->count() > 0; @endphp
                @if(!$hasReplied)
                    <form id="replyForm{{ $rating->id }}" action="{{ route('rating.reply.store', $rating->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="reply" class="form-control" placeholder="Tulis balasan..." required>
                            <button type="submit" class="btn btn-warning text-dark fw-semibold">Balas</button>
                        </div>
                    </form>
                @endif
            @endif
        </div>
    @empty
        <p class="text-center text-muted fade-in">Belum ada ulasan pelanggan.</p>
    @endforelse
</div>

{{-- ✨ STYLE TAMBAHAN --}}
<style>
    .profile-frame { border: 4px solid #ffc107; border-radius: 50%; }
    .hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 10px; }
    .hover-card:hover { transform: translateY(-6px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
    .photo-overlay { background: rgba(0,0,0,0.45); opacity: 0; transition: opacity 0.3s ease; }
    .hover-card:hover .photo-overlay { opacity: 1; }
    textarea { resize: none; }
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }

    /* DARK MODE */
    body.dark-mode { background-color: #121212; color: #eee; }
    body.dark-mode .card, body.dark-mode .alert, body.dark-mode .border, body.dark-mode .bg-light {
        background-color: #1e1e1e !important; color: #ddd;
    }
    body.dark-mode .text-dark { color: #f8f9fa !important; }
    body.dark-mode .btn-outline-dark { border-color: #ffc107; color: #ffc107; }
    body.dark-mode .btn-outline-dark:hover { background-color: #ffc107; color: #000; }
</style>

{{-- 🚀 SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // SweetAlert success popup
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    // Dark mode toggle
    const toggle = document.getElementById('theme-toggle');
    const body = document.body;
    const isDark = localStorage.getItem('theme') === 'dark';
    if (isDark) {
        body.classList.add('dark-mode');
        toggle.textContent = '🌚 Dark';
    }

    toggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        const dark = body.classList.contains('dark-mode');
        toggle.textContent = dark ? '🌚 Dark' : '🌞 Light';
        localStorage.setItem('theme', dark ? 'dark' : 'light');
    });
});
</script>

<script>
function openViewer(src) {
    document.getElementById('viewerImage').src = src;
    document.getElementById('photoViewer').classList.remove('d-none');
}

function closeViewer() {
    document.getElementById('photoViewer').classList.add('d-none');
    document.getElementById('viewerImage').src = '';
}

// klik background untuk nutup
document.getElementById('photoViewer').addEventListener('click', function(e) {
    if (e.target === this) closeViewer();
});
</script>

@endsection
