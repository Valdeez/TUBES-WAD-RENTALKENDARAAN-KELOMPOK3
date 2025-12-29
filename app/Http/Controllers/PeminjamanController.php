<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Motor;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PeminjamanController
{
    public function index()
    {
        $peminjamans = Peminjaman::where('user_id', 1)->with('kendaraan')->latest()->get();

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

        // Tentukan model kendaraan
        $kendaraan = $this->getKendaraan(
            $request->kendaraan_type,
            $request->kendaraan_id
        );

        // Cek ketersediaan kendaraan
        if ($kendaraan->status !== 'tersedia') {
            return response()->json([
                'message' => 'Kendaraan sedang tidak tersedia'
            ], 422);
        }

        // Simpan peminjaman
        $peminjaman = Peminjaman::create([
            // 'user_id'         => auth()->id(),
            'user_id'         => 1,
            'kendaraan_id'    => $kendaraan->id,
            'kendaraan_type'  => get_class($kendaraan),
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => Carbon::parse($request->tanggal_pinjam)->addDays((int)$request->durasi),
            'durasi'          => $request->durasi,
            'status'          => 'disewa',
        ]);

        // Update status kendaraan
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
        $peminjaman = Peminjaman::with('kendaraan')->findOrFail($id);

        // if ($peminjaman->user_id !== auth()->id()) {
        //     abort(403, 'Anda tidak memiliki akses ke data ini.');
        // }

        return view('Peminjaman.detailPeminjaman', compact('peminjaman'));
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with('kendaraan')->findOrFail($id);

        if ($peminjaman->status === 'dikembalikan') {
            return response()->json([
                'message' => 'Peminjaman sudah dikembalikan'
            ], 422);
        }

        $tanggalKembali = Carbon::now();

        $peminjaman->update([
            'tanggal_kembali' => $tanggalKembali,
            'status'          => 'dikembalikan'
        ]);

        // Update status kendaraan
        $peminjaman->kendaraan->update([
            'status' => 'tersedia'
        ]);

        return response()->json([
            'message' => 'Kendaraan berhasil dikembalikan',
            'data'    => $peminjaman
        ]);
    }

    private function getKendaraan($type, $id)
    {
        return match ($type) {
            'motor' => Motor::findOrFail($id),
            'mobil' => Mobil::findOrFail($id),
        };
    }
}