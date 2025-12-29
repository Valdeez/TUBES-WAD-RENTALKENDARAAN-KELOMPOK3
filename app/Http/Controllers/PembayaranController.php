<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PembayaranResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
   public function index()
    {
        $userId = Auth::id();
        $transaksi = Pembayaran::with(['peminjaman.kendaraan'])
            ->whereHas('peminjaman', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->get();

        return view('pembayaran.history', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'metode'        => 'required',
            'jumlah_bayar'  => 'required|numeric|min:1',
            'bukti'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak valid',
                'errors'  => $validator->errors()
            ], 422);
        }

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        $path = $request->file('bukti')->store('bukti_bayar', 'public');

        Pembayaran::create([
        'peminjaman_id' => $request->peminjaman_id,
        'tanggal_bayar' => now(),
        'jumlah_bayar'  => $request->jumlah_bayar,
        'metode'        => $request->metode,
        'status'        => 'menunggu_verifikasi',
        'bukti'         => $path,           
    ]);

        // return (new PembayaranResource($pembayaran))
        //     ->additional(['message' => 'Pembayaran berhasil dibuat'])
        //     ->response()
        //     ->setStatusCode(201);
        return redirect()->route('peminjaman.show', $peminjaman->id)->with('success', 'Pembayaran berhasil dibuat dan sedang diproses.');
    }

    public function create($id)
    {
        $peminjaman = Peminjaman::with(['user', 'kendaraan'])->findOrFail($id);

        // if ($peminjaman->user_id !== Auth::id()) {
        //     abort(403, 'Anda tidak berhak membayar tagihan ini.');
        // }
        $totalBayar = $peminjaman->kendaraan->harga_sewa * $peminjaman->durasi;

        return view('Pembayaran.createPembayaran', compact('peminjaman', 'totalBayar'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:lunas,ditolak'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'status' => $request->status
        ]);
        if($request->status == 'lunas') {
            $pembayaran->peminjaman->update(['status' => 'disewa']); 
        } elseif($request->status == 'ditolak') {
            $pembayaran->peminjaman->update(['status' => 'menunggu_pembayaran']); 
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui!');
    }
}
