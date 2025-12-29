<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tailor;
use Illuminate\Http\Request;

class TailorController extends Controller
{
    public function index()
    {
        $tailors = Tailor::all();
        return response()->json(['success' => true, 'data' => $tailors]);
    }

    public function show($id)
    {
        $tailor = Tailor::find($id);
        if (!$tailor) {
            return response()->json(['success' => false, 'message' => 'Tailor tidak ditemukan']);
        }
        return response()->json(['success' => true, 'data' => $tailor]);
    }

    public function store(Request $request)
    {
        $tailor = Tailor::create($request->all());
        return response()->json(['success' => true, 'data' => $tailor]);
    }
}
