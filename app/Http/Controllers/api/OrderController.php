<?
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'tailor'])->get();
        return response()->json(['success' => true, 'data' => $orders]);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'tailor'])->find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan']);
        }
        return response()->json(['success' => true, 'data' => $order]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tailor_id' => 'required|exists:tailors,id',
            'ukuran' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
            'status' => 'nullable|string'
        ]);

        $order = Order::create($validated);
        return response()->json(['success' => true, 'data' => $order]);
    }
}
