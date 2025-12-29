<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PembayaranResource;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    public function index()
    {
        return PembayaranResource::collection(
            Pembayaran::with('peminjaman')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'metode'        => 'required|in:transfer,cash,ewallet',
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

        $path = $request->file('bukti')->store('uploads/bukti_bayar', 'public');

        $pembayaran = Pembayaran::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_bayar' => now(),
            'jumlah_bayar'  => $request->jumlah_bayar,
            'metode'        => $request->metode,
            'status'        => 'pending',
            'bukti'         => $path,
        ]);

        return (new PembayaranResource($pembayaran))
            ->additional(['message' => 'Pembayaran berhasil dibuat'])
            ->response()
            ->setStatusCode(201);
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

        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        Storage::disk('public')->delete($pembayaran->bukti);
        $pembayaran->delete();

        return response()->json(['message' => 'Pembayaran berhasil dihapus'], 200);
    }
}
