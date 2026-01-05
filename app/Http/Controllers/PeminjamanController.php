<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Motor;
use App\Models\Mobil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PeminjamanController
{
    public function index()
    {
        $peminjamans = Peminjaman::where('user_id', Auth::id())->with(['kendaraan', 'pembayaran'])->latest()->get();

        return view('Peminjaman.peminjaman', compact('peminjamans'));
    }

    public function create($id, $type)
    {
        if ($type === 'motor') {
            $kendaraan = \App\Models\Motor::findOrFail($id);
        } else {
            $kendaraan = \App\Models\Mobil::findOrFail($id);
        }
        return view('Peminjaman.createPeminjaman', compact('kendaraan', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_type' => 'required|in:motor,mobil',
            'kendaraan_id'   => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'durasi'         => 'required|integer|min:1'
        ]);

        $kendaraan = $this->getKendaraan(
            $request->kendaraan_type,
            $request->kendaraan_id
        );

        if ($kendaraan->status !== 'tersedia') {
            return response()->json([
                'message' => 'Kendaraan sedang tidak tersedia'
            ], 422);
        }

        $peminjaman = Peminjaman::create([
            'user_id'         => Auth::id(),
            'kendaraan_id'    => $kendaraan->id,
            'kendaraan_type'  => get_class($kendaraan),
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => Carbon::parse($request->tanggal_pinjam)->addDays((int)$request->durasi),
            'durasi'          => $request->durasi,
        ]);

        $kendaraan->update([
            'status' => 'disewa'
        ]);

        // return response()->json([
        //     'message' => 'Peminjaman berhasil dibuat',
        //     'data'    => $peminjaman
        // ], 201);
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dibuat');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['kendaraan', 'review'])->findOrFail($id);

        return view('Peminjaman.detailPeminjaman', compact('peminjaman'));
    }

    public function update($id)
    {
        $peminjaman = Peminjaman::with('kendaraan')->findOrFail($id);
        
        $tanggalKembali = Carbon::now();

        $peminjaman->update([
            'tanggal_kembali' => $tanggalKembali,
            'status'          => 'selesai'
        ]);

        $peminjaman->kendaraan->update([
            'status' => 'tersedia'
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diselesaikan.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::with('kendaraan')->findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }

    private function getKendaraan($type, $id)
    {
        return match ($type) {
            'motor' => Motor::findOrFail($id),
            'mobil' => Mobil::findOrFail($id),
        };
    }
}