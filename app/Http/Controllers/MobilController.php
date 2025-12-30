<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\MobilResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MobilController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobils = Mobil::latest()->get();
        // return new MobilResource(true, 'List Data Mobil', $mobils);
        return view('Mobil.mobil', compact('mobils'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('Mobil.createMobil');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'              => 'required',
            'plat_nomor'        => 'required|',
            'tipe'              => 'required',
            'tahun_produksi'    => 'required|integer',
            'warna'             => 'required',
            'harga_sewa'        => 'required|numeric',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imagePath = $request->file('gambar')->store('mobils', 'public');

        // 3. Simpan ke Database
        $mobil = Mobil::create([
            'nama'              => $request->nama,
            'plat_nomor'        => $request->plat_nomor,
            'tipe'              => $request->tipe,
            'tahun_produksi'    => $request->tahun_produksi,
            'warna'             => $request->warna,
            'harga_sewa'        => $request->harga_sewa,
            'gambar'            => $imagePath,
        ]);
        return redirect()->route('mobil.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return response()->json(['message' => 'Data Mobil tidak ditemukan!'], 404);
        }
        $reviews = Review::whereIn('peminjaman_id', $mobil->peminjamans->pluck('id'))->latest()->get();

        return view('Mobil.detailMobil', compact('mobil', 'reviews'));;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $mobil = \App\Models\Mobil::find($id);

        if (!$mobil) {
            return redirect()->route('mobil')->with('error', 'Data tidak ditemukan');
        }

        // 2. Validasi Input
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'plat_nomor' => 'required|unique:mobils,plat_nomor,' . $mobil->id,
            'warna' => 'required',
            'harga_sewa' => 'required|numeric',
            'tahun_produksi' => 'nullable|numeric',
            'status' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 3. Cek apakah user upload gambar baru?
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada (opsional, biar server gak penuh)
            if ($mobil->gambar && \Illuminate\Support\Facades\Storage::exists('public/' . $mobil->gambar)) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $mobil->gambar);
            }

            // Simpan gambar baru
            $imagePath = $request->file('gambar')->store('mobils', 'public');
            $mobil->gambar = $imagePath;
        }

        // 4. Update data lainnya
        $mobil->nama = $request->nama;
        $mobil->tipe = $request->tipe;
        $mobil->plat_nomor = $request->plat_nomor;
        $mobil->warna = $request->warna;
        $mobil->tahun_produksi = $request->tahun_produksi;
        $mobil->harga_sewa = $request->harga_sewa;
        $mobil->status = $request->status;

        // Simpan ke database
        $mobil->save();
        // 5. Redirect kembali ke halaman utama
        return redirect()->route('mobil.index')->with('success', 'Data mobil berhasil diperbarui!');
    
    }

    public function edit($id)
    {
        // Cari data mobil berdasarkan ID
        $mobil = Mobil::find($id);

        // Kirim data $mobil ke view 'edit'
        return view('Mobil.editMobil', compact('mobil'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return response()->json(['message' => 'Data Mobil tidak ditemukan'], 404);
        }

        if ($mobil->gambar) {
            Storage::delete('public/mobils/' . $mobil->gambar);
        }

        $mobil->delete();
        return redirect()->route('mobil.index')->with('success', 'Data mobil berhasil dihapus!');
    }
}
