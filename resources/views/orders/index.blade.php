@extends('layouts.cust')

@section('content')

@php
    // Foto yang ditampilkan: gunakan foto yang dipilih dari controller (kalau ada)
    $displayPhoto = $selectedPhoto ?? $tailor->photos->first();
@endphp

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-warning">🧵 Pesan Pakaian Custom</h2>
        <p class="text-muted">Buat pakaian impianmu sesuai desain dan bahan pilihanmu.</p>
    </div>

    {{-- FOTO YANG DIPILIH --}}
    @if($displayPhoto)
    <div class="text-center mb-4">
        <img src="{{ asset('storage/' . $displayPhoto->path) }}" 
             alt="Foto Pilihan" 
             class="img-fluid rounded shadow-sm mb-3" 
             style="max-height: 300px;">
        @if($displayPhoto->extra_price)
            <h5 class="fw-bold text-warning">
                Harga Tambahan: Rp {{ number_format($displayPhoto->extra_price, 0, ',', '.') }}
            </h5>
        @endif
    </div>
    @endif

    {{-- DETAIL PENJAHIT --}}
    @if(isset($tailor))
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-light">
            <h4 class="fw-bold">{{ $tailor->name ?? $tailor->nama }}</h4>
            <p class="text-muted">{{ $tailor->deskripsi }}</p>
            <p><strong>Harga Jasa:</strong> 
                <span class="text-warning fw-semibold">
                    Rp {{ number_format($tailor->harga, 0, ',', '.') }}
                </span>
            </p>
        </div>
    </div>
    @endif

    {{-- FORM PEMESANAN --}}
    <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" 
          class="p-4 bg-white border rounded shadow-sm">
        @csrf
        <input type="hidden" name="product_id" value="{{ $tailor->id ?? '' }}">
        @if($displayPhoto)
            <input type="hidden" name="photo_id" value="{{ $displayPhoto->id }}">
        @endif

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Pesanan</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Kemeja Kantor Custom" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Ukuran</label>
            <input type="text" name="ukuran" class="form-control" placeholder="Contoh: L, M, XL, sesuai ukuran" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi Tambahan</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Ceritakan keinginan model pakaian Anda..."></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Upload Desain</label>
            <input type="file" name="design" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
        </div>

        {{-- TAMBAHAN (OPSIONAL) --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Tambahan (opsional)</label>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="extras[]" id="extra1" value="Bordir|20000">
                <label class="form-check-label" for="extra1">
                    Bordir (+Rp 20.000)
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="extras[]" id="extra2" value="Kancing Premium|10000">
                <label class="form-check-label" for="extra2">
                    Kancing Premium (+Rp 10.000)
                </label>
            </div>

            {{-- Tambahan otomatis dari foto (bahan penjahit) --}}
            @if($displayPhoto && $displayPhoto->extra_price)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="extras[]" 
                       id="extra3" value="Bahan Penjahit|{{ $displayPhoto->extra_price }}" checked>
                <label class="form-check-label fw-semibold text-warning" for="extra3">
                    Bahan dari Penjahit (Rp {{ number_format($displayPhoto->extra_price, 0, ',', '.') }})
                </label>
            </div>
            @endif
        </div>

        {{-- TOTAL HARGA --}}
        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark">
                Total Awal: Rp {{ number_format($harga, 0, ',', '.') }}
            </h4>
        </div>

        <button type="submit" class="btn btn-warning text-dark fw-semibold w-100 shadow-sm">
            💳 Lanjut ke Pembayaran
        </button>
    </form>

    {{-- PANDUAN UKURAN --}}
    <section id="size-guide" class="bg-light py-5 mt-5 rounded shadow-sm">
        <div class="container">
            <h3 class="text-center mb-4 text-warning fw-bold">📏 Panduan Ukuran Umum</h3>
            <p class="text-center text-muted mb-4">
                Pastikan ukuran Anda akurat agar hasil jahitan pas dan nyaman. 
                Kami juga menerima ukuran custom sesuai permintaan.
            </p>

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-warning">
                        <tr>
                            <th>Ukuran</th>
                            <th>Dada (cm)</th>
                            <th>Pinggang (cm)</th>
                            <th>Panjang Baju (cm)</th>
                            <th>Panjang Lengan (cm)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>S</td><td>88–92</td><td>72–76</td><td>65</td><td>60</td></tr>
                        <tr><td>M</td><td>93–97</td><td>77–81</td><td>67</td><td>62</td></tr>
                        <tr><td>L</td><td>98–102</td><td>82–86</td><td>69</td><td>64</td></tr>
                        <tr><td>XL</td><td>103–107</td><td>87–91</td><td>71</td><td>66</td></tr>
                        <tr><td>XXL</td><td>108–112</td><td>92–96</td><td>73</td><td>68</td></tr>
                    </tbody>
                </table>
            </div>

            <p class="text-center mt-3 fst-italic text-muted">
                * Ukuran dapat disesuaikan sesuai permintaan khusus Anda.
            </p>
        </div>
    </section>
</div>
@endsection
