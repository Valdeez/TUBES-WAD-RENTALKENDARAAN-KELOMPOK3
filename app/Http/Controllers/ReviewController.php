<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::with('kendaraan')->findOrFail($request->peminjaman_id);

        if ($peminjaman->status !== 'dikembalikan') {
            return response()->json([
                'message' => 'Review hanya bisa diberikan setelah kendaraan dikembalikan'
            ], 422);
        }

        if ($peminjaman->review) {
            return response()->json([
                'message' => 'Review sudah pernah diberikan'
            ], 422);
        }

        $review = Review::create([
            'user_id' => auth()->id(), 
            'peminjaman_id' => $peminjaman->id,
            'rating'=>  $request->rating,
            'comment'=> $request->comment,
            'reviewable_id'=> $peminjaman->kendaraan->id,
            'reviewable_type'=> get_class($peminjaman->kendaraan),
        ]);

        return response()->json([
            'message' => 'Review berhasil ditambahkan',
            'data'    => $review
        ], 201);
    }
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $peminjamanId = $review->peminjaman_id;
        
        $review->delete(); 

        return response()->json([
            'message' => 'Review berhasil dihapus!',
            'data'    => $review
        ], 201);
    }
}