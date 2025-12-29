@extends('layouts.app')
@section('content')
{{-- <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fffbea;
    }

    header {
        background: linear-gradient(135deg, #ffc107, #ffdd57);
        color: #3a3a3a;
    }

    header h1 {
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    .btn-light {
        background: #fff;
        color: #3a3a3a;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background: #3a3a3a;
        color: #fff;
        transform: translateY(-2px);
    }

    section {
        animation: fadeInUp 0.8s ease both;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-material {
        border: none;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .card-material:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .card-material img {
        border-radius: 15px 15px 0 0;
        height: 220px;
        object-fit: cover;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    footer {
        background-color: #fff3cd;
        box-shadow: 0 -2px 5px rgba(0,0,0,0.05);
    }

    /* 🔸 Responsif Fix */
    @media (max-width: 768px) {
        header h1 {
            font-size: 1.8rem;
        }
        header p {
            font-size: 1rem;
        }
    }
</style> --}}

<header class="text-center py-5">
    <div class="container">
        <h1 class="display-5 fw-bold">Pesan Pakaian Custom dari Penjahit Terpercaya</h1>
        <p class="lead mb-4">Mudah, cepat, dan hasil sesuai keinginanmu!</p>
        <a href="{{ url('user/dashboard') }}" class="btn btn-light btn-lg shadow-sm">
            <i class="bi bi-bag-check"></i> Mulai Pesan Sekarang
        </a>
    </div>
</header>

<section id="how-it-works" class="py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-4 text-dark">Cara Pemesanan</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-material p-4">
                    <i class="bi bi-ui-checks display-4 text-warning mb-3"></i>
                    <h5>1. Pilih Model</h5>
                    <p>Pilih desain dan jenis pakaian yang sesuai gayamu.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-material p-4">
                    <i class="bi bi-rulers display-4 text-warning mb-3"></i>
                    <h5>2. Kirim Ukuran</h5>
                    <p>Masukkan ukuran dan detail agar hasilnya pas di badan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-material p-4">
                    <i class="bi bi-truck display-4 text-warning mb-3"></i>
                    <h5>3. Terima Pakaian</h5>
                    <p>Tunggu hasilnya dikirim, dijamin rapi dan berkualitas.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="fabric-info" class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-4 text-dark">Informasi Bahan Pakaian</h2>
        <div class="row g-4">
            @php
                $materials = [
                    ['img' => 'https://cdn.shopify.com/s/files/1/0305/2116/3913/files/cotton_480x480.jpg?v=1700110595', 'title' => 'Katun (Cotton)', 'desc' => 'Lembut, adem, dan nyaman dipakai — cocok untuk iklim tropis.'],
                    ['img' => 'https://cdn.shopify.com/s/files/1/0305/2116/3913/files/polyester_1_480x480.jpg?v=1700110572', 'title' => 'Polyester', 'desc' => 'Tahan lama, cepat kering, dan sering dipakai untuk pakaian olahraga.'],
                    ['img' => 'https://cdn.shopify.com/s/files/1/0305/2116/3913/files/nylon_480x480.jpg?v=1700110758', 'title' => 'Nylon', 'desc' => 'Ringan, kuat, dan elastis — sering dipakai untuk bahan tas dan jaket.'],
                    ['img' => 'https://cdn.shopify.com/s/files/1/0305/2116/3913/files/linen_1_480x480.jpg?v=1700110532', 'title' => 'Linen', 'desc' => 'Dingin, menyerap keringat, dan tampak elegan di segala acara.'],
                    ['img' => 'https://cdn.shopify.com/s/files/1/0305/2116/3913/files/satin_480x480.jpg?v=1700110616', 'title' => 'Satin', 'desc' => 'Mengkilap dan mewah — cocok untuk gaun atau acara spesial.'],
                    ['img' => 'https://cdn.shopify.com/s/files/1/0305/2116/3913/files/rayon_480x480.jpg?v=1700110641', 'title' => 'Rayon', 'desc' => 'Sejuk dan halus, sering digunakan untuk pakaian santai.'],
                ];
            @endphp

            @foreach ($materials as $mat)
                <div class="col-md-4">
                    <div class="card-material h-100">
                        <img src="{{ $mat['img'] }}" alt="{{ $mat['title'] }}" class="img-fluid">
                        <div class="p-3">
                            <h5 class="fw-bold">{{ $mat['title'] }}</h5>
                            <p>{{ $mat['desc'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="size-guide" class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-4 text-dark">Panduan Ukuran Umum</h2>
        <div class="table-responsive shadow-sm rounded">
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
                    <tr><td>S</td><td>88-92</td><td>72-76</td><td>65</td><td>60</td></tr>
                    <tr><td>M</td><td>93-97</td><td>77-81</td><td>67</td><td>62</td></tr>
                    <tr><td>L</td><td>98-102</td><td>82-86</td><td>69</td><td>64</td></tr>
                    <tr><td>XL</td><td>103-107</td><td>87-91</td><td>71</td><td>66</td></tr>
                    <tr><td>XXL</td><td>108-112</td><td>92-96</td><td>73</td><td>68</td></tr>
                </tbody>
            </table>
        </div>
        <p class="text-center mt-3 fst-italic">* Ukuran bisa disesuaikan sesuai permintaan khusus.</p>
    </div>
</section>

<section id="contact" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-3 text-dark">Hubungi Kami</h2>
        <p class="mb-4">Ada pertanyaan? Tim kami siap bantu kamu kapan aja.</p>
        <div class="d-flex justify-content-center gap-5 flex-wrap">
            <div><i class="bi bi-envelope text-warning fs-3"></i><p>support@penjahitonline.com</p></div>
            <div><i class="bi bi-telephone text-warning fs-3"></i><p>+62 812 3456 7890</p></div>
            <div><i class="bi bi-geo-alt text-warning fs-3"></i><p>Jl. Contoh No.123, Jakarta</p></div>
        </div>
    </div>
</section>

{{-- <footer class="text-center py-3 bg-warning text-dark shadow-sm">
    <small>&copy; {{ date('Y') }} <strong>N’Jait</strong> — Semua Hak Dilindungi</small>
</footer> --}}
@endsection
