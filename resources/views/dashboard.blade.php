@php
    use Illuminate\Support\Facades\Auth;

    if (Auth::check()) {
        $role = Auth::user()->role ?? 'customer';
        $layout = $role === 'tailor' ? 'layouts.tailor' : 'layouts.cust';
    } else {
        $layout = 'layouts.app';
    }
@endphp

@extends($layout)

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pesan Pakaian Online - Penjahit Terpercaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    
    <header class="bg-warning text-white text-center py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Pesan Pakaian Custom ke Penjahit Terpercaya</h1>
            <p class="lead mb-4">Mudah, cepat, dan hasil sesuai keinginan Anda</p>
            <a href="user/dashboard" class="btn btn-light btn-lg">Mulai Pesan Sekarang</a>
        </div>
    </header>

    <section id="how-it-works" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Cara Pemesanan</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <h5 class="mt-3">1. Pilih Model Pakaian</h5>
                    <p>Pilih desain dan jenis pakaian yang Anda inginkan.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="mt-3">2. Kirim Ukuran & Detail</h5>
                    <p>Masukkan ukuran dan detail khusus untuk pakaian Anda.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="mt-3">3. Terima Pakaian</h5>
                    <p>Penjahit membuat pakaian sesuai keingan anda dengan kualitas terbaik.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="fabric-info" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Informasi Bahan Pakaian</h2>
        <p class="text-center mb-5 fs-5">
            Memilih bahan yang tepat adalah kunci kenyamanan dan kualitas pakaian Anda. Kami menyediakan berbagai pilihan bahan berkualitas tinggi yang cocok untuk berbagai kebutuhan dan gaya.
        </p>
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <img src="https://cdn.shopify.com/s/files/1/0305/2116/3913/files/cotton_480x480.jpg?v=1700110595" alt="Katun" class="img-fluid rounded mb-3" />
                <h5>Katun (Cotton)</h5>
                <p>Bahan katun adalah bahan yang terbuat dari serat kapas yang diolah menjadi benang. Benang-benang tersebut disusun untuk menjadi kain siap pakai, sehingga terciptalah baju katun yang sampai saat ini banyak dijual.

Memiliki tekstur yang lembut dan halus, membuat kain katun nyaman dikenakan. Bahannya yang adem juga membuat baju katun cocok dipakai di area tropis.</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="https://cdn.shopify.com/s/files/1/0305/2116/3913/files/polyester_1_480x480.jpg?v=1700110572" alt="Polyester" class="img-fluid rounded mb-3" />
                <h5>Polyester</h5>
                <p> bahan polyester juga termasuk jenis kain yang banyak digunakan sebagai bahan pembuatan pakaian. Berbahan dasar serat sintetis yang berasal dari senyawa kimia, tentunya ketahanan kain polyester tidak perlu diragukan lagi.

Selain itu, kain polyester juga cepat dalam menyerap keringat. Maka tak heran kalau polyester menjadi salah satu bahan yang umum dipakai untuk pembuatan pakaian olahraga ataupun pakaian sehari-hari, seperti blus.</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="https://cdn.shopify.com/s/files/1/0305/2116/3913/files/nylon_480x480.jpg?v=1700110758" alt="nylon" class="img-fluid rounded mb-3">
                <h5>Nylon</h5>
                <p>Nilon adalah bahan yang terbuat dari sintetis dan memiliki karakter yang kuat, ringan, dan elastis. Bahan nilon juga memiliki daya tahan yang cukup baik sehingga tidak mudah rusak. Biasanya nilon banyak digunakan untuk bahan pembuatan tas.</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="https://cdn.shopify.com/s/files/1/0305/2116/3913/files/linen_1_480x480.jpg?v=1700110532" alt="linen" class="img-fluid rounded mb-3">
                <h5>Linen</h5>
                <p>Linen termasuk salah satu jenis kain yang cukup populer. Banyak produsen pakaian yang menggunakan linen sebagai bahan pembuatan pakaian. Hal ini karena linen memiliki serat yang cukup tebal, namun tetap ringan dipakai dan mudah menyerap, sehingga cocok dipakai di segala situasi panas maupun dingin.

Tak hanya banyak dipakai untuk pembuatan kemeja atau tunik, linen juga banyak digunakan untuk bahan pembuatan sprei, handuk, karpet, dan taplak meja. Jika dirawat dengan baik, bahan linen dapat digunakan dalam waktu yang lama.</p>

            </div>
            <div class="col-md-4 text-center">
                <img src="https://cdn.shopify.com/s/files/1/0305/2116/3913/files/satin_480x480.jpg?v=1700110616" alt="satin" class="img-fluid rounded mb-3">
                <h5>Satin</h5>
                <p>Kain satin adalah termasuk jenis kain yang ditenun menggunakan teknik serat filamen seperti sutra ( sutra ) atau non poliester. Tujuan utama penerapan teknik ini adalah untuk menghasilkan kain dengan permukaan yang mengkilap  dan berkilau sehingga terkesan mewah.

Biasanya bahan satin sering digunakan untuk pembuatan gaun dan baju atasan . Namun tak sedikit juga kain satin dipakai sebagai bahan jilbab, terutama hijab selendang pashmina. Teksturnya yang elegan membuat bahan satin cocok dipakai untuk menghadiri acara spesial.</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="https://cdn.shopify.com/s/files/1/0305/2116/3913/files/rayon_480x480.jpg?v=1700110641" alt="Rayon" class="img-fluid rounded mb-3">
                <h5>Rayon</h5>
                <p>Kain rayon memiliki karakteristik yang nyaman dan sejuk. Kain ini memiliki daya serap keringat yang baik, sehingga cocok digunakan di daerah tropis, seperti Indonesia. Selain itu, kain rayon juga memiliki tekstur yang lembut dan halus.

Adapun kain rayon banyak digunakan untuk membuat pakaian, seperti daster, kemeja, dan rok. Selain itu, rayon juga bisa digunakan untuk membuat selimut, sprei, dan tirai.</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="https://cdn.shopify.com/s/files/1/0305/2116/3913/files/DSC04013_6401af92-48d1-447c-b60a-df0d552e6d6b_480x480.jpg?v=1700110714" alt="spandex" class="img-fluid rounded mb-3">
                <h5>Spandex</h5>
                <p>Bahan spandek merupakan salah satu jenis bahan kain yang sering digunakan dan cukup populer, khususnya di kalangan wanita. Kain spandex sendiri merupakan salah satu jenis kain yang memiliki ciri khas sebagai bahan yang elastis.

Kain spandek banyak ditemukan pada jilbab, ciput, dalaman baju, celana ketat, baju olahraga, hingga baju renang.</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="https://cdn.shopify.com/s/files/1/0305/2116/3913/files/DENIMSHIRTWITHTIE1_1_480x480.jpg?v=1700110802" alt="Sutra" class="img-fluid rounded mb-3" />
                <h5>Denim</h5>
                <p>Bahan kain denim adalah jenis kain yang terbuat dari serat katun berwarna biru atau indigo. Kain denim merupakan jenis kain yang cukup kuat karena ditenun menggunakan katun tenun kepar  secara diagonal.

Bahan kain denim juga disebut sebagai kain jeans karena memang sering dijadikan bahan baku pembuatan jeans.</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="https://cdn.shopify.com/s/files/1/0305/2116/3913/files/DSC01763_480x480.jpg?v=1700111313" alt="wol" class="img-fluid rounded mb-3">
                <h5>Wol</h5>
                <p>Kalau kamu menyukai bahan-bahan kain yang biasanya dipakai untuk membuat pakaian dan aksesori branded, coba gunakan kain bahan tweed. Tekstur kain tweednya menyerupai bahan katun yang kasar dan biasanya terbuat dari wol.

Karakteristik lainnya adalah jenis kain wol tweed biasanya ditenun menggunakan benang dengan warna yang berbeda-beda untuk membentuk pola dan warna yang dinamis.</p>
            </div>
        </div>
    </div>
</section>

<section id="size-guide" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">Panduan Ukuran Umum</h2>
        <p class="text-center mb-5 fs-5">
            Agar pakaian yang Anda pesan pas dan nyaman, berikut panduan ukuran umum yang kami gunakan dalam pembuatan. Pastikan mengukur dengan benar atau konsultasikan dengan kami untuk ukuran khusus.
        </p>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Ukuran</th>
                        <th>Dada (cm)</th>
                        <th>Pinggang (cm)</th>
                        <th>Panjang Baju (cm)</th>
                        <th>Panjang Lengan (cm)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>S</td>
                        <td>88 - 92</td>
                        <td>72 - 76</td>
                        <td>65</td>
                        <td>60</td>
                    </tr>
                    <tr>
                        <td>M</td>
                        <td>93 - 97</td>
                        <td>77 - 81</td>
                        <td>67</td>
                        <td>62</td>
                    </tr>
                    <tr>
                        <td>L</td>
                        <td>98 - 102</td>
                        <td>82 - 86</td>
                        <td>69</td>
                        <td>64</td>
                    </tr>
                    <tr>
                        <td>XL</td>
                        <td>103 - 107</td>
                        <td>87 - 91</td>
                        <td>71</td>
                        <td>66</td>
                    </tr>
                    <tr>
                        <td>XXL</td>
                        <td>108 - 112</td>
                        <td>92 - 96</td>
                        <td>73</td>
                        <td>68</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-center mt-4 fst-italic">
            * Ukuran dapat disesuaikan sesuai permintaan khusus Anda.
        </p>
    </div>
</section>
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Hubungi Kami</h2>
            <p class="text-center mb-4">Ada pertanyaan? Silakan hubungi kami melalui email atau telepon.</p>
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <p><strong>Email:</strong> support@penjahitonline.com</p>
                    <p><strong>Telepon:</strong> +62 812 3456 7890</p>
                    <p><strong>Alamat:</strong> Jl. Contoh No.123, Jakarta, Indonesia</p>
                </div>
            </div>
        </div>
    </section>

    {{-- <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            &copy; {{ date('Y') }} PenjahitOnline. Semua hak cipta dilindungi.
        </div>
    </footer> --}}
    <footer class="text-center py-4 bg-warning text-dark mt-5 shadow-sm">
        <small>&copy; {{ date('Y') }} N’Jait - Semua Hak Dilindungi</small>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection