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
        $peminjamans = Peminjaman::with(['user', 'kendaraan'])->latest()->get();

        return response()->json($peminjamans);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_type' => 'required|in:motor,mobil',
            'kendaraan_id'   => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'durasi'         => 'required'
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
            'user_id'         => auth()->id(),
            'kendaraan_id'    => $kendaraan->id,
            'kendaraan_type'  => get_class($kendaraan),
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'durasi'          => $request->durasi,
            'status'          => 'dipinjam',
        ]);

        // Update status kendaraan
        $kendaraan->update([
            'status' => 'dipinjam'
        ]);

        return response()->json([
            'message' => 'Peminjaman berhasil dibuat',
            'data'    => $peminjaman
        ], 201);
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'kendaraan'])->findOrFail($id);

        return response()->json($peminjaman);
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