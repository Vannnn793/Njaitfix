@extends('layouts.tailor')

@section('content')
<div class="container py-5">

    {{-- Header Halaman --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-receipt"></i> Detail Pesanan #{{ $order->id }}
        </h2>
        <p class="text-muted">Lihat informasi lengkap pesanan dari pelanggan Anda.</p>
    </div>

    {{-- Card Detail --}}
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-warning text-dark fw-semibold">
            <i class="bi bi-person-circle"></i> Pelanggan: {{ $order->user->name }}
        </div>

        <div class="card-body bg-light">

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nama Pakaian:</strong><br> {{ $order->nama }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Jumlah:</strong><br> {{ $order->jumlah }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Ukuran:</strong><br> {{ $order->ukuran }}</p>
                </div>
            </div>

            <div class="mb-3">
                <p><strong>Deskripsi:</strong><br> 
                    {{ $order->deskripsi ?: '-' }}
                </p>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Harga Total:</strong><br>
                        <span class="fw-bold text-dark bg-warning px-3 py-1 rounded">
                            Rp {{ number_format($order->harga, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status Pesanan:</strong></p>
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                        @csrf
                        <select name="status" onchange="this.form.submit()" 
                                class="form-select border-warning shadow-sm">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </form>
                </div>
            </div>

            @if($order->tambahan)
                <div class="mb-3">
                    <p><strong>Tambahan:</strong><br>
                        <span class="badge bg-dark text-warning">{{ $order->tambahan }}</span>
                    </p>
                </div>
            @endif

            <div class="mb-4">
                <p><strong>Desain:</strong></p>
                <a href="{{ asset('storage/' . $order->design) }}" 
                   target="_blank" 
                   class="btn btn-warning text-dark fw-semibold shadow-sm">
                    <i class="bi bi-image"></i> Lihat Desain
                </a>
            </div>
        </div>

        <div class="card-footer text-end bg-warning bg-opacity-25">
            <a href="{{ route('admin.orders') }}" class="btn btn-outline-dark fw-semibold">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</div>
@endsection
