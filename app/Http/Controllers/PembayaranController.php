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
        $request->validate([
        'peminjaman_id' => 'required|exists:peminjamans,id',
        'metode'        => 'required',                 
        'jumlah_bayar'  => 'required|numeric',
        'bukti'         => 'required|image|max:2048',  
            ]);

        $path = $request->file('bukti')->store('uploads/bukti_bayar', 'public');

        Pembayaran::create([
        'peminjaman_id' => $request->peminjaman_id,
        'tanggal_bayar' => now(),
        'jumlah_bayar'  => $request->jumlah_bayar,
        'metode'        => $request->metode,
        'status'        => 'menunggu_verifikasi',
        'bukti'         => $path,           
    ]);

       return redirect('/history')->with('success', 'Pembayaran berhasil dikirim! Mohon tunggu verifikasi.');
    }
public function adminIndex()
    {
        // Menampilkan semua data (Pagination)
        $pembayaran = Pembayaran::with(['peminjaman.user', 'peminjaman.kendaraan'])
                        ->latest()
                        ->paginate(10); 

        return view('admin.pembayaran.index', compact('pembayaran'));
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
