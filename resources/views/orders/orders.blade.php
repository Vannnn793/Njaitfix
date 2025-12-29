@extends('layouts.cust')

@section('content')
<div class="container py-5">

    {{-- Judul --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold text-warning">
            <i class="bi bi-receipt-cutoff"></i> Pesanan Saya
        </h2>
        <p class="text-muted">Lihat dan kelola semua pesanan yang telah kamu buat</p>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Jika kosong --}}
    @if($orders->isEmpty())
        <div class="text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="120" class="mb-3" alt="Empty">
            <h5 class="text-muted mb-3">Belum ada pesanan yang dibuat</h5>
            <a href="{{ route('user.welcome') }}" class="btn btn-warning text-dark fw-semibold px-4">
                <i class="bi bi-shop"></i> Mulai Belanja
            </a>
        </div>
    @else
        {{-- Tabel pesanan --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-warning text-center">
                            <tr>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Ukuran</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                @php
                                    $rating = \App\Models\Rating::where('order_id', $order->id)
                                        ->where('user_id', auth()->id())
                                        ->first();
                                @endphp

                                <tr>
                                    <td>{{ $order->nama }}</td>
                                    <td class="text-center">{{ $order->jumlah }}</td>
                                    <td class="text-center">{{ $order->ukuran }}</td>
                                    <td>{{ $order->deskripsi ?: '-' }}</td>
                                    <td class="fw-bold text-end">Rp {{ number_format($order->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if($order->status === 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($order->status === 'diproses')
                                            <span class="badge bg-warning text-dark">Diproses</span>
                                        @else
                                            <span class="badge bg-secondary">Pending</span>
                                        @endif
                                    </td>

                                    <td class="text-center">

                                        {{-- Tombol Pembayaran --}}
                                        @if($order->status === 'pending')
                                            <a href="{{ route('order.payment', $order->id) }}" 
                                               class="btn btn-sm btn-warning text-dark fw-semibold">
                                                <i class="bi bi-credit-card"></i> Bayar
                                            </a>
                                        @endif

                                        {{-- Tombol Lihat Desain --}}
                                        <a href="{{ asset('storage/'.$order->design) }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-dark">
                                            <i class="bi bi-image"></i> Lihat Desain
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('rmv', ['id' => $order->id]) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>

                                        {{-- Tombol Rating --}}
                                        @if($order->status === 'selesai')
                                            <button class="btn btn-sm btn-outline-primary mt-2" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#rateForm{{ $order->id }}">
                                                {{ $rating ? '✏️ Edit Rating' : '⭐ Beri Rating' }}
                                            </button>

                                            {{-- Form Rating --}}
                                            <div class="collapse mt-2" id="rateForm{{ $order->id }}">
                                                <form action="{{ route('order.rate', $order->id) }}" 
                                                      method="POST" 
                                                      enctype="multipart/form-data" 
                                                      class="p-2 border rounded bg-light text-start">
                                                    @csrf
                                                    <div class="mb-2">
                                                        <label class="form-label">Rating</label>
                                                        <select name="rating" class="form-select" required>
                                                            @for ($i = 5; $i >= 1; $i--)
                                                                <option value="{{ $i }}" 
                                                                    {{ $rating && $rating->rating == $i ? 'selected' : '' }}>
                                                                    {{ str_repeat('⭐', $i) }} ({{ $i }})
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label">Komentar</label>
                                                        <textarea name="comment" class="form-control" rows="2" placeholder="Bagaimana hasil jahitannya?">{{ $rating->comment ?? '' }}</textarea>
                                                    </div>

                                                    {{-- Foto Review --}}
                                                    <div class="mb-2">
                                                        <label class="form-label">Upload Foto Review</label>
                                                        <input type="file" name="photo" class="form-control" accept="image/*">
                                                        @if($rating && $rating->photo_path)
                                                            <div class="mt-2">
                                                                <img src="{{ asset('storage/' . $rating->photo_path) }}" 
                                                                     alt="Foto Review" 
                                                                     class="rounded shadow-sm"
                                                                     style="width: 100px; height: 100px; object-fit: cover;">
                                                                <p class="text-muted small mt-1">*Mengunggah foto baru akan menggantikan yang lama</p>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <button type="submit" class="btn btn-sm btn-warning w-100 text-dark fw-semibold">
                                                        {{ $rating ? 'Update Rating' : 'Kirim Rating' }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
