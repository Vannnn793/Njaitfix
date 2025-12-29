@extends('layouts.tailor')

@section('content')
<div class="container py-5">

    {{-- 🧭 Header --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-list-task text-warning"></i> Manajemen Pesanan & Keuangan
        </h2>
        <p class="text-muted">Pantau, kelola, dan analisis performa bisnismu di satu tempat 💼</p>
    </div>

    {{-- ✅ Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 📦 Daftar Pesanan --}}
    <div class="card border-0 shadow-lg mb-5">
        <div class="card-header bg-warning d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-box2-heart-fill"></i> Daftar Pesanan
            </h5>
            <span class="badge bg-dark text-warning fs-6 px-3 py-2 shadow-sm">
                {{ $orders->count() }} Pesanan
            </span>
        </div>

        <div class="card-body bg-light p-4">
            {{-- 🖥️ Tabel Desktop --}}
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-warning text-dark">
                        <tr>
                            <th>Customer</th>
                            <th>Nama Pakaian</th>
                            <th>Harga</th>
                            <th>Tambahan</th>
                            <th>Status</th>
                            <th>Ubah Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="align-middle">
                                <td class="fw-semibold">{{ $order->user->name }}</td>
                                <td>{{ $order->nama }}</td>
                                <td class="text-success fw-bold">Rp {{ number_format($order->harga, 0, ',', '.') }}</td>
                                <td class="text-danger">{{ $order->extra_price ? 'Rp '.number_format($order->extra_price, 0, ',', '.') : '-' }}</td>
                                <td>
                                    <span class="badge px-3 py-2 bg-{{ 
                                        $order->status === 'selesai' ? 'success' : 
                                        ($order->status === 'diproses' ? 'warning text-dark' : 'secondary') 
                                    }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="d-inline">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm border-warning shadow-sm fw-semibold" onchange="this.form.submit()">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.show', $order->id) }}" class="btn btn-sm btn-outline-dark fw-semibold shadow-sm">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-4">
                                    <i class="bi bi-inbox me-2"></i> Belum ada pesanan masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 📱 Tampilan Mobile --}}
            <div class="d-md-none">
                @forelse($orders as $order)
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body bg-white rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-bold mb-0">{{ $order->nama }}</h5>
                                <span class="badge bg-{{ 
                                    $order->status === 'selesai' ? 'success' : 
                                    ($order->status === 'diproses' ? 'warning text-dark' : 'secondary') 
                                }} px-2 py-1">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <p class="mb-1"><strong>Customer:</strong> {{ $order->user->name }}</p>
                            <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($order->harga, 0, ',', '.') }}</p>
                            <p class="mb-2"><strong>Tambahan:</strong> {{ $order->extra_price ? 'Rp '.number_format($order->extra_price, 0, ',', '.') : '-' }}</p>

                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="mb-3">
                                @csrf
                                <select name="status" class="form-select form-select-sm border-warning shadow-sm" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>

                            <a href="{{ route('admin.show', $order->id) }}" class="btn btn-sm btn-warning w-100 fw-semibold text-dark shadow-sm">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox"></i> Belum ada pesanan masuk.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- 💰 REKAP KEUANGAN --}}
    @php
        $pemasukan = $orders->where('status', 'selesai')->sum('harga');
        $pengeluaran = $orders->where('status', 'selesai')->sum('extra_price');
        $profit = $pemasukan - $pengeluaran;
        $chartData = $orders->where('status', 'selesai')
            ->groupBy(fn($o) => $o->created_at->format('d M'))
            ->map(fn($g) => [
                'income' => $g->sum('harga'),
                'expense' => $g->sum('extra_price'),
            ]);
    @endphp

    <div class="row g-4 mt-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success bg-opacity-25 text-dark text-center py-4">
                <i class="bi bi-wallet2 fs-1 text-success mb-2"></i>
                <h5 class="fw-bold">Total Pemasukan</h5>
                <h3 class="fw-bold text-success">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-danger bg-opacity-25 text-dark text-center py-4">
                <i class="bi bi-tools fs-1 text-danger mb-2"></i>
                <h5 class="fw-bold">Biaya Tambahan (Pengeluaran)</h5>
                <h3 class="fw-bold text-danger">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-warning bg-opacity-25 text-dark text-center py-4">
                <i class="bi bi-graph-up-arrow fs-1 text-warning mb-2"></i>
                <h5 class="fw-bold">Total Keuntungan</h5>
                <h3 class="fw-bold text-warning">Rp {{ number_format($profit, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- 📊 Grafik Keuangan --}}
    <div class="card mt-5 border-0 shadow-sm">
        <div class="card-header bg-dark text-warning fw-bold">
            <i class="bi bi-bar-chart-line me-2"></i> Grafik Tren Keuangan
        </div>
        <div class="card-body bg-light">
            <canvas id="financeChart" height="100"></canvas>
        </div>
    </div>
</div>

{{-- 📈 Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('financeChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData->keys()) !!},
        datasets: [
            {
                label: 'Pemasukan',
                data: {!! json_encode($chartData->pluck('income')) !!},
                borderColor: '#198754',
                backgroundColor: 'rgba(25,135,84,0.2)',
                tension: 0.3,
                fill: true
            },
            {
                label: 'Pengeluaran',
                data: {!! json_encode($chartData->pluck('expense')) !!},
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220,53,69,0.2)',
                tension: 0.3,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

{{-- 🎨 Style Tambahan --}}
<style>
    .table th {
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .card { border-radius: 12px; transition: 0.3s ease; }
    .card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .form-select:focus { box-shadow: 0 0 0 0.25rem rgba(255,193,7,0.25); }
</style>
@endsection
