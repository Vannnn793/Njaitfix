<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tailor;
use App\Models\Rating;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RatingController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $user = Auth::user();

        // 🔒 Pastikan user adalah pemilik pesanan
        if ($order->user_id !== $user->id) {
            return back()->with('error', 'Kamu tidak diizinkan memberi rating untuk pesanan ini.');
        }

        // ✅ Hanya bisa beri rating kalau pesanan selesai
        if ($order->status !== 'selesai') {
            return back()->with('error', 'Kamu hanya bisa memberi rating setelah pesanan selesai.');
        }

        // 🧾 Validasi input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 📂 Cek apakah sudah pernah beri rating sebelumnya
        $existingRating = Rating::where('user_id', $user->id)
            ->where('order_id', $order->id)
            ->first();

        // 📸 Upload foto jika ada
        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('ratings', 'public');

            // Jika sudah ada rating dan ada foto lama → hapus dulu
            if ($existingRating && $existingRating->photo_path) {
                Storage::disk('public')->delete($existingRating->photo_path);
            }
        }

        if ($existingRating) {
            // 🛠️ Update rating lama
            $existingRating->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? $existingRating->comment,
                'photo_path' => $path ?? $existingRating->photo_path,
            ]);

            return back()->with('success', 'Rating kamu berhasil diperbarui!');
        }

        // ✨ Buat rating baru
        Rating::create([
            'user_id' => $user->id,
            'tailor_id' => $order->tailor_id,
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'photo_path' => $path,
        ]);

        return back()->with('success', 'Terima kasih! Rating kamu berhasil dikirim.');
    }
}
