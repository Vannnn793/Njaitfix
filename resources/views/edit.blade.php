@extends('layouts.tailor')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- 🧵 Kartu Utama --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-gradient bg-warning text-dark text-center py-4">
                    <h3 class="fw-bold mb-0">
                        <i class="bi bi-person-badge-fill me-2"></i> Edit Profil Penjahit
                    </h3>
                    <p class="text-muted mb-0">Perbarui profilmu dan lihat langsung tampilannya secara real-time ✨</p>
                </div>

                <div class="card-body bg-light p-4">
                    {{-- ✅ Notifikasi --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- ✏️ Form Edit Profil --}}
                    <form method="POST" action="{{ route('update') }}" enctype="multipart/form-data" id="editProfileForm">
                        @csrf

                        {{-- 🖼️ Foto Profil --}}
                        <div class="mb-4 text-center">
                            <div class="position-relative d-inline-block">
                                <img id="previewImage"
                                    src="{{ asset('storage/' . ($tailor->user->pp ?? 'default-avatar.png')) }}"
                                    class="rounded-circle shadow-sm border border-3 border-warning mb-3"
                                    width="130" height="130" alt="Foto Profil">
                                <label for="pp" class="btn btn-sm btn-dark rounded-circle position-absolute bottom-0 end-0">
                                    <i class="bi bi-camera-fill text-warning"></i>
                                </label>
                            </div>
                            <input type="file" name="pp" id="pp" class="d-none" accept="image/*" onchange="previewProfile(event)">
                            <div id="uploadProgress" class="progress mt-2 d-none" style="height: 6px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;"></div>
                            </div>
                            <p class="text-muted small mt-2">Klik ikon kamera untuk mengganti foto profil</p>
                        </div>

                        {{-- Nama --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nama" id="nama"
                                   placeholder="Nama Penjahit" value="{{ old('nama', $tailor->nama ?? '') }}"
                                   oninput="updatePreview()">
                            <label for="nama"><i class="bi bi-person"></i> Nama Lengkap</label>
                        </div>

                        {{-- Umur --}}
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="umur" id="umur"
                                   placeholder="Umur" value="{{ old('umur', $tailor->umur ?? '') }}"
                                   oninput="validateAge()">
                            <label for="umur"><i class="bi bi-calendar-heart"></i> Umur</label>
                            <div class="invalid-feedback">Umur minimal 15 tahun ya!</div>
                        </div>

                        {{-- Alamat --}}
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="alamat" id="alamat" style="height: 100px"
                                      placeholder="Alamat lengkap" oninput="updatePreview()">{{ old('alamat', $tailor->alamat ?? '') }}</textarea>
                            <label for="alamat"><i class="bi bi-geo-alt-fill"></i> Alamat Lengkap</label>
                        </div>

                        {{-- Nomor HP --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="no_hp" id="no_hp"
                                   placeholder="Nomor HP" value="{{ old('no_hp', $tailor->no_hp ?? '') }}"
                                   oninput="updatePreview()">
                            <label for="no_hp"><i class="bi bi-phone"></i> Nomor HP</label>
                        </div>

                        {{-- Skill --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="skill" id="skill"
                                   placeholder="Skill" value="{{ old('skill', $tailor->skill ?? '') }}"
                                   oninput="updatePreview()">
                            <label for="skill"><i class="bi bi-scissors"></i> Spesialisasi / Skill</label>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="deskripsi" id="deskripsi" style="height: 100px"
                                      placeholder="Deskripsi singkat" oninput="updatePreview()">{{ old('deskripsi', $tailor->deskripsi ?? '') }}</textarea>
                            <label for="deskripsi"><i class="bi bi-chat-square-text"></i> Deskripsi Singkat</label>
                        </div>

                        {{-- Harga --}}
                        <div class="form-floating mb-4">
                            <input type="number" class="form-control" name="harga" id="harga"
                                   placeholder="Harga Dasar" value="{{ old('harga', $tailor->harga ?? '') }}"
                                   oninput="updatePreview()">
                            <label for="harga"><i class="bi bi-cash-coin"></i> Harga Dasar (Rp)</label>
                            <small class="text-muted ms-2">*Masukkan hanya angka tanpa titik atau koma</small>
                        </div>

                        {{-- Tombol --}}
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning fw-bold px-5 py-2 shadow-sm rounded-pill text-dark">
                                <i class="bi bi-save2 me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- 💡 Preview Profil Real-time --}}
            <div class="card mt-5 border-0 shadow-sm bg-white rounded-4 text-center p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-eye-fill text-warning"></i> Preview Profil Kamu</h5>
                <img id="liveImage" src="{{ asset('storage/' . ($tailor->user->pp ?? 'default-avatar.png')) }}"
                     class="rounded-circle border border-3 border-warning shadow-sm mb-3" width="110" height="110">
                <h4 id="liveName" class="fw-bold text-dark">{{ $tailor->nama ?? 'Nama Penjahit' }}</h4>
                <p id="liveSkill" class="text-muted mb-1">{{ $tailor->skill ?? 'Skill belum diisi' }}</p>
                <p id="liveDesc" class="text-secondary">{{ $tailor->deskripsi ?? 'Deskripsi akan tampil di sini...' }}</p>
                <p id="liveHarga" class="fw-semibold text-success mt-2">Rp {{ number_format($tailor->harga ?? 0, 0, ',', '.') }}</p>
            </div>

        </div>
    </div>
</div>

{{-- 📸 Script Preview + UX --}}
<script>
    function previewProfile(event) {
        const reader = new FileReader();
        const progressBar = document.querySelector('#uploadProgress');
        const bar = progressBar.querySelector('.progress-bar');
        progressBar.classList.remove('d-none');
        reader.onloadstart = () => { bar.style.width = '0%'; };
        reader.onprogress = e => {
            if (e.lengthComputable) {
                const percent = (e.loaded / e.total) * 100;
                bar.style.width = `${percent}%`;
            }
        };
        reader.onloadend = () => {
            document.getElementById('previewImage').src = reader.result;
            document.getElementById('liveImage').src = reader.result;
            bar.style.width = '100%';
            setTimeout(() => progressBar.classList.add('d-none'), 500);
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function updatePreview() {
        document.getElementById('liveName').textContent = document.getElementById('nama').value || 'Nama Penjahit';
        document.getElementById('liveSkill').textContent = document.getElementById('skill').value || 'Skill belum diisi';
        document.getElementById('liveDesc').textContent = document.getElementById('deskripsi').value || 'Deskripsi akan tampil di sini...';
        const harga = document.getElementById('harga').value || 0;
        document.getElementById('liveHarga').textContent = 'Rp ' + Number(harga).toLocaleString('id-ID');
    }

    function validateAge() {
        const umur = document.getElementById('umur');
        if (umur.value && umur.value < 15) {
            umur.classList.add('is-invalid');
        } else {
            umur.classList.remove('is-invalid');
        }
    }
</script>

{{-- 🎨 Style --}}
<style>
    .card-header {
        background: linear-gradient(90deg, #ffc107, #ffcd39);
    }
    .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.3);
    }
    .progress-bar {
        transition: width 0.3s ease-in-out;
    }
    .btn-warning:hover {
        background-color: #ffca2c;
        transform: scale(1.05);
        transition: 0.3s;
    }
    #previewImage, #liveImage {
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    #previewImage:hover, #liveImage:hover {
        transform: scale(1.05);
    }
</style>
@endsection
