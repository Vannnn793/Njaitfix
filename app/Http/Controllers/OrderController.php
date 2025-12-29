<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Tailor;
use App\Models\Photo;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Create Order Page
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        $tailor = Tailor::with('photos')->findOrFail($request->product_id);
        $harga = $tailor->harga;

        $selectedPhoto = null;

        if ($request->has('photo_id')) {
            $selectedPhoto = Photo::where('id', $request->photo_id)
                ->where('user_id', $tailor->user_id)
                ->first();

            if ($selectedPhoto && $selectedPhoto->extra_price) {
                $harga += $selectedPhoto->extra_price;
            }
        }

        return view('orders.index', compact('tailor', 'harga', 'selectedPhoto'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create Order + Send to Midtrans
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'ukuran' => 'required',
            'design' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'product_id' => 'required|exists:tailors,id',
        ]);

        $tailor = Tailor::findOrFail($request->product_id);
        $base = (int) $tailor->harga;

        $designPath = $request->file('design')->store('designs', 'public');

        $extraPrice = 0;
        $extraItems = [];
        $extraText = null;

        if ($request->extras) {
            $extraText = implode(', ', collect($request->extras)->map(function ($item) use (&$extraPrice, &$extraItems) {
                [$name, $price] = explode('|', $item);
                $price = (int) $price;

                $extraPrice += $price;

                $extraItems[] = [
                    'id' => 'extra-' . $name,
                    'price' => $price,
                    'quantity' => 1,
                    'name' => "Tambahan: {$name}"
                ];

                return "{$name} (+" . number_format($price) . ")";
            })->toArray());
        }

        $finalPrice = ($base + $extraPrice) * $request->jumlah;

        $order = Order::create([
            'user_id' => auth()->id(),
            'tailor_id' => $tailor->id,
            'nama' => $request->nama,
            'jumlah' => $request->jumlah,
            'ukuran' => $request->ukuran,
            'deskripsi' => $request->deskripsi,
            'design' => $designPath,
            'harga' => $finalPrice,
            'tambahan' => $extraText,
            'status' => 'pending'
        ]);

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => "ORDER-{$order->id}-" . time(),
                'gross_amount' => $finalPrice,
            ],
            'item_details' => array_merge([[
                'id' => "produk-{$tailor->id}",
                'price' => $base + $extraPrice,
                'quantity' => $request->jumlah,
                'name' => "Pemesanan: {$tailor->name}",
            ]], $extraItems),
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('orders.payment', compact('snapToken', 'order'));
    }

    /*
    |--------------------------------------------------------------------------
    | Midtrans Payment Page (manual pay)
    |--------------------------------------------------------------------------
    */

    public function payment(Order $order)
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => "ORDER-{$order->id}-" . time(),
                'gross_amount' => (int) $order->harga,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('orders.payment', compact('snapToken', 'order'));
    }

    /*
    |--------------------------------------------------------------------------
    | Midtrans Callback (FINAL FIXED)
    |--------------------------------------------------------------------------
    */

public function handleCallback(Request $request)
{
    Log::info("MIDTRANS CALLBACK RECEIVED", $request->all());

    $serverKey = config('midtrans.serverKey');

    // verifikasi signature
    $hash = hash("sha512",
        $request->order_id .
        $request->status_code .
        $request->gross_amount .
        $serverKey
    );

    if ($hash !== $request->signature_key) {
        Log::error("INVALID SIGNATURE");
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    // ambil id order asli
    $orderId = explode('-', $request->order_id)[1];
    $order = Order::find($orderId);

    if (!$order) {
        Log::error("ORDER NOT FOUND: {$orderId}");
        return response()->json(['message' => 'Order not found'], 404);
    }

    // update status berdasarkan Midtrans
    switch ($request->transaction_status) {
        case 'capture':
        case 'settlement':
            $order->status = 'diproses';
            break;

        case 'pending':
            $order->status = 'pending';
            break;

        case 'deny':
        case 'expire':
        case 'cancel':
            $order->status = 'gagal';
            break;
    }

    $order->save();

    Log::info("ORDER UPDATED: {$order->id} → {$order->status}");

    // WAJIB return 200 agar Midtrans tidak retry
    return response()->json([
        'success' => true,
        'status' => $order->status
    ], 200);
}

    /*
    |--------------------------------------------------------------------------
    | List orders
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('orders.orders', compact('orders'));
    }

    public function del($id)
    {
        Order::where('id', $id)->delete();
        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | Admin / Tailor
    |--------------------------------------------------------------------------
    */

    public function Admin()
    {
        $penjahitId = auth()->id();

        $orders = Order::whereHas('tailor', function ($q) use ($penjahitId) {
            $q->where('user_id', $penjahitId);
        })->get();

        return view('admin.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return view('admin.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,gagal'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders')->with('success', 'Status diperbarui.');
    }
}
