<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Tailor;
use lluminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua user yang punya role penjahit
    $photos = Photo::with(['tailor.user'])->latest()->get();

    // Kirim ke view
    return view('user.dashboard', compact('photos'));}

     public function search(Request $request)
    {
        $query = $request->q;

        $photos = Photo::with('user.tailor')
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhereHas('tailor', function ($t) use ($query) {
                      $t->where('deskripsi', 'LIKE', "%{$query}%")
                        ->orWhere('harga', 'LIKE', "%{$query}%");
                  });
            })
            ->latest()
            ->get();

        return view('user.dashboard', compact('photos'));
    }
}

