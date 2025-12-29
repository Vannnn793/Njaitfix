<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\RatingReply;
use Illuminate\Support\Facades\Auth;

class RatingReplyController extends Controller
{
    public function store(Request $request, Rating $rating)
    {
        $request->validate(['reply' => 'required|string|max:1000']);

        RatingReply::create([
            'rating_id' => $rating->id,
            'user_id' => auth()->id(),
            'reply' => $request->reply,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim!');
    }

    public function update(Request $request, RatingReply $reply)
    {
        $request->validate(['reply' => 'required|string|max:1000']);

        // Pastikan hanya tailor pemilik balasan yang bisa edit
        if ($reply->user_id !== auth()->id()) {
            abort(403);
        }

        $reply->update(['reply' => $request->reply]);

        return back()->with('success', 'Balasan berhasil diperbarui!');
    }
}
