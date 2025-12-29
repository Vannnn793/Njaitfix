<?
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\RatingReply;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::with('replies')->get();
        return response()->json(['success' => true, 'data' => $ratings]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tailor_id' => 'required|exists:tailors,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $rating = Rating::create($validated);
        return response()->json(['success' => true, 'data' => $rating]);
    }

    public function reply(Request $request)
    {
        $validated = $request->validate([
            'rating_id' => 'required|exists:ratings,id',
            'user_id' => 'required|exists:users,id',
            'reply' => 'required|string'
        ]);

        $reply = RatingReply::create($validated);
        return response()->json(['success' => true, 'data' => $reply]);
    }
}
