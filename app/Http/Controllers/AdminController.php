<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tailor;
use App\Models\Photo; // atau sesuaikan nama model path fotonya
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\OrderStatusUpdated;
use App\Models\Order;


class AdminController extends Controller
{

public function index()
{
    $user = Auth::user(); // ambil user yang login
    $tailor = Tailor::where('user_id', $user->id)
                    ->with(['ratings.user']) // ambil juga data rating + nama user pemberi rating
                    ->first();

    // Ambil foto profil (kalau ada)
    $photo = $tailor 
        ? Photo::where('user_id', $tailor->id)->first()
        : null;

    $tailor_photos = Photo::where('user_id', $user->id)->get();

    return view('admin.dashboard', compact('user','tailor', 'photo', 'tailor_photos'));
}

public function edit() {
        $tailor = Tailor::where("user_id", Auth::user()->id)->first();
        $user = auth()->user();
        $tailor_photos = Photo::where('user_id', $user->id)->get();
        return view('edit', compact('user', 'tailor', 'tailor_photos'));
    }
public function handleTailorPhoto(Request $request)
{
    $request->validate([
        'photo.*'      => 'required|image|mimes:jpeg,png,jpg|max:4096', // multiple support
        'extra_price'  => 'nullable|numeric|min:0',
    ]);

    $user = auth()->user();

    // Cek apakah user punya data tailor
    $tailor = $user->tailor;
    if (!$tailor) {
        return redirect()->back()->with('error', 'Data penjahit tidak ditemukan.');
    }

    // Pastikan ada file yang diupload
    if ($request->hasFile('photo')) {
        foreach ($request->file('photo') as $file) {
            $path = $file->store('tailor_photos', 'public');

            // Simpan ke database
            Photo::create([
                'user_id'      => $user->id,
                'tailor_id'    => $tailor->id,
                'path'         => $path,
                'extra_price'  => $request->extra_price ?? 0,
            ]);
        }
    }

    return redirect()->route('admin.dashboard')
                     ->with('success', 'Foto karya berhasil diupload!');
}

public function update(Request $request)
{
    // ✅ Validasi input
    $data = $request->validate([
        'nama' => 'nullable|string',
        'umur'=> 'nullable|string',
        'skill' => 'nullable|string',
        'alamat' => 'nullable|string',
        'no_hp' => 'nullable|string',
        'deskripsi' => 'nullable|string',
        'harga'=> 'nullable|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'pp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // ✅ Ambil user login & data tailor
    $user = auth()->user();
    $tailor = Tailor::where('user_id', $user->id)->first();

    // Jika belum ada data tailor, buat baru
    if (!$tailor) {
        $tailor = Tailor::create(['user_id' => $user->id]);
    }

    // ✅ Update data tailor
    $tailor->update([
        'nama' => $data['nama'] ?? $tailor->nama,
        'umur' => $data['umur'] ?? $tailor->umur,
        'alamat' => $data['alamat'] ?? $tailor->alamat,
        'skill' => $data['skill'] ?? $tailor->skill,
        'no_hp' => $data['no_hp'] ?? $tailor->no_hp,
        'deskripsi' => $data['deskripsi'] ?? $tailor->deskripsi,
        'harga' => $data['harga'] ?? $tailor->harga,
    ]);

    // ✅ Update nama di tabel users
    if (!empty($data['nama'])) {
        $user->update(['name' => $data['nama']]);
    }

    // ✅ Upload foto profil (pp)
    if ($request->hasFile('pp')) {
        $pp = $request->file('pp');
        $newPath = $pp->store('profile_photos', 'public');
        $user->update(['pp' => $newPath]);
    }

    // ✅ Upload foto karya (photo)
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $path = $photo->store('photos', 'public');

        Photo::create([
            'user_id' => $user->id,
            'path' => $path,
        ]);
    }
    
    // ✅ Redirect ke dashboard admin setelah update
    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Profil berhasil diperbarui!');
}

public function show(Request $request, $userId)
{
    // Ambil data tailor beserta user, foto, rating, dan balasan
    $tailor = \App\Models\Tailor::where('user_id', $userId)
        ->with([
            'user',
            'photos',
            'ratings.user',          // pelanggan yang memberikan rating
            'ratings.replies.user'   // balasan dari tailor
        ])
        ->firstOrFail();

    // Ambil semua foto milik tailor ini
    $photos = \App\Models\Photo::where('user_id', $userId)->get();

    // Tentukan foto yang dipilih (jika ada)
    $selectedPhoto = null;
    if ($request->has('photo_id')) {
        $selectedPhoto = \App\Models\Photo::where('id', $request->photo_id)
            ->where('user_id', $userId)
            ->first();
    }

    // Jika tidak ada photo_id, pakai foto pertama
    if (!$selectedPhoto) {
        $selectedPhoto = $photos->first();
    }

    return view('user.tailor-detail', compact('tailor', 'photos', 'selectedPhoto'));
}



    public function deletePhoto($id) {
    $photo = Photo::findOrFail($id);
    Storage::disk('public')->delete($photo->path);
    $photo->delete();
    return back()->with('success', 'Karya berhasil dihapus!');
}

public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    // 🔥 kirim event realtime ke user
    broadcast(new OrderStatusUpdated($order))->toOthers();

    return back()->with('success', 'Status pesanan berhasil diperbarui!');
}

}
