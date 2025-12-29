@extends('layouts.cust')

@section('content')
<div class="container py-5 text-center">
    <h2>💳 Proses Pembayaran</h2>
    <p class="mb-4">Silakan selesaikan pembayaran Anda untuk pesanan: <strong>{{ $order->nama }}</strong></p>

    <button id="pay-button" class="btn btn-success btn-lg">Bayar Sekarang</button>

    <script
        type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.clientKey') }}">
    </script>

    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("✅ Pembayaran Berhasil!");
                    window.location.href = "{{ route('orders.index') }}";
                },
                onPending: function(result){
                    alert("🕓 Menunggu pembayaran...");
                    window.location.href = "{{ route('order.create') }}";
                },
                onError: function(result){
                    alert("❌ Pembayaran gagal.");
                    console.error(result);
                },
                onClose: function(){
                    alert("❗ Anda menutup popup tanpa menyelesaikan pembayaran.");
                }
            });
        });
    </script>
</div>
@endsection
