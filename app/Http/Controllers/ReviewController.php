<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Peminjaman;

class ReviewController
{
    public function create($peminjaman_id)
    {
        $peminjaman = Peminjaman::with('kendaraan')
            ->where('id', $peminjaman_id)
            ->where('user_id', Auth::id())
            ->where('status', 'Selesai')
            ->firstOrFail();
        
        $peminjaman->tgl_pinjam_formatted = \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M Y');
        $peminjaman->tgl_kembali_formatted = \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->translatedFormat('d M Y');

        if ($peminjaman->review()->exists()) {
            return redirect()->back()->with('error', 'Ulasan sudah pernah dibuat.');
        }

        return view('Review.createReview', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        $review = Review::create([
            'user_id' => Auth::id(),
            'peminjaman_id' => $request->peminjaman_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $type = strtolower(class_basename($peminjaman->kendaraan_type)); 
        return redirect()->route($type . '.detail', $peminjaman->kendaraan_id)->with('success', 'Ulasan Anda berhasil ditambahkan!');
    }

    /**
     * Update review (Hanya pemilik ulasan)
     */
    public function edit(Review $review)
    {
        // if ($review->peminjaman->user_id !== auth()->id()) {
        //     abort(403);
        // }

        $review->load('peminjaman.kendaraan');
        $review->peminjaman->tgl_pinjam_formatted = \Carbon\Carbon::parse($review->peminjaman->tanggal_pinjam)->translatedFormat('d M Y');
        $review->peminjaman->tgl_kembali_formatted = \Carbon\Carbon::parse($review->peminjaman->tanggal_kembali)->translatedFormat('d M Y');
        
        return view('Review.editReview', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        // if ($review->peminjaman->user_id !== auth()->id()) {
        //     abort(403);
        // }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review->update($request->only('rating', 'comment'));

        $type = strtolower(class_basename($review->peminjaman->kendaraan_type));
        return redirect()->route($type . '.detail', $review->peminjaman->kendaraan_id)->with('success', 'Ulasan berhasil diperbarui!');
    }

    /**
     * Hapus review (Pemilik atau Admin)
     */
    public function destroy(Review $review)
    {
        // if ($review->peminjaman->user_id !== Auth::id()) {
        //     abort(403);
        // }

        $review->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus!');
    }
}