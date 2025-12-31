<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PembayaranResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PembayaranController 
{
   public function index()
    {
        $userId = Auth::id() ?? 1;
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

        $pembayaran = Pembayaran::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_bayar' => now(),
            'jumlah_bayar'  => $request->jumlah_bayar,
            'metode'        => $request->metode,
            'status'        => 'pending',
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

    public function show($id)
    {
        $pembayaran = Pembayaran::with('peminjaman')->find($id);

        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        return new PembayaranResource($pembayaran);
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,lunas,gagal',
            'bukti'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('bukti')) {
            Storage::disk('public')->delete($pembayaran->bukti);
            $pembayaran->bukti = $request->file('bukti')
                ->store('uploads/bukti_bayar', 'public');
        }

        $pembayaran->status = $request->status;
        $pembayaran->save();

        if ($request->status === 'lunas') {
            $peminjaman = $pembayaran->peminjaman;

            if ($peminjaman->totalDibayar() >= $peminjaman->total_tagihan) {
                $peminjaman->update(['status' => 'selesai']);
            }
        }

        return (new PembayaranResource($pembayaran))
            ->additional(['message' => 'Status pembayaran diperbarui'])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::find($id);
        $pembayaran = \App\Models\Pembayaran::findOrFail($id);
        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }
        if ($pembayaran->bukti) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pembayaran->bukti);
        }

        Storage::disk('public')->delete($pembayaran->bukti);
        $pembayaran->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
    public function adminIndex()
    {
        // Ambil SEMUA data (Pagination 10)
        $pembayaran = Pembayaran::with(['peminjaman.user', 'peminjaman.kendaraan'])
                        ->latest()
                        ->paginate(10); 

        return view('Pembayaran.adminPembayaran', compact('pembayaran'));
    }

    // 5. Proses Admin Terima/Tolak
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:lunas,dibatalkan'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        
        // Update Status Pembayaran
        $pembayaran->update([
            'status' => $request->status
        ]);

        // Update Status Peminjaman
        if($request->status == 'lunas') {
            $pembayaran->peminjaman->update(['status' => 'disewa']); 
        } elseif($request->status == 'dibatalkan') {
            $pembayaran->peminjaman->update(['status' => 'dibatalkan']); 
            $pembayaran->peminjaman->kendaraan->update(['status' => 'tersedia']);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}
