<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;
use App\Http\Resources\MotorResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MotorController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motors = Motor::latest()->get();
        // return new MotorResource(true, 'List Data Motor', $motors);
        return view('Motor.motor', compact('motors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('Motor.createMotor');
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

        $imagePath = $request->file('gambar')->store('motors', 'public');

        // 3. Simpan ke Database
        $motor = Motor::create([
            'nama'              => $request->nama,
            'plat_nomor'        => $request->plat_nomor,
            'tipe'              => $request->tipe,
            'tahun_produksi'    => $request->tahun_produksi,
            'warna'             => $request->warna,
            'harga_sewa'        => $request->harga_sewa,
            'gambar'            => $imagePath,
        ]);
        return redirect()->route('motor');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $motor = Motor::find($id);

        if (!$motor) {
            return response()->json(['message' => 'Data Motor tidak ditemukan!'], 404);
        }
        return view('Motor.detailMotor', compact('motor'));;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $motor = \App\Models\Motor::find($id);

        if (!$motor) {
            return redirect()->route('motor')->with('error', 'Data tidak ditemukan');
        }

        // 2. Validasi Input
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'plat_nomor' => 'required|unique:motors,plat_nomor,' . $motor->id,
            'warna' => 'required',
            'harga_sewa' => 'required|numeric',
            'tahun_produksi' => 'nullable|numeric',
            'status' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 3. Cek apakah user upload gambar baru?
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada (opsional, biar server gak penuh)
            if ($motor->gambar && \Illuminate\Support\Facades\Storage::exists('public/' . $motor->gambar)) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $motor->gambar);
            }

            // Simpan gambar baru
            $imagePath = $request->file('gambar')->store('motors', 'public');
            $motor->gambar = $imagePath;
        }

        // 4. Update data lainnya
        $motor->nama = $request->nama;
        $motor->tipe = $request->tipe;
        $motor->plat_nomor = $request->plat_nomor;
        $motor->warna = $request->warna;
        $motor->tahun_produksi = $request->tahun_produksi;
        $motor->harga_sewa = $request->harga_sewa;
        $motor->status = $request->status;

        // Simpan ke database
        $motor->save();

        // 5. Redirect kembali ke halaman utama
        return redirect()->route('motor')->with('success', 'Data motor berhasil diperbarui!');
    
    }

    public function edit($id)
    {
        // Cari data motor berdasarkan ID
        $motor = Motor::find($id);

        // Kirim data $motor ke view 'edit'
        return view('Motor.editMotor', compact('motor'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $motor = Motor::find($id);

        if (!$motor) {
            return response()->json(['message' => 'Data Motor tidak ditemukan'], 404);
        }

        if ($motor->gambar) {
            Storage::delete('public/motors/' . $motor->gambar);
        }

        $motor->delete();
        return redirect()->route('motor')->with('success', 'Data motor berhasil dihapus!');
    }
}
