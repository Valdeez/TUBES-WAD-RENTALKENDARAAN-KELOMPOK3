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
        return new MotorResource(true, 'List Data Motor', $motors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'              => 'required',
            'plat_nomor'        => 'required|unique:motors',
            'tipe'              => 'required',
            'tahun_produksi'    => 'required|integer',
            'warna'             => 'required',
            'harga_sewa'        => 'required|numeric',
            'status'            => 'required|in:tersedia,disewa,maintenance',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
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
            'status'            => $request->status,
            'gambar'            => $imagePath,
        ]);
        return new MotorResource(true, 'Data Motor Berhasil Ditambahkan!', $motor);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $motor = Motor::find($id);

        if(!$motor){
            return response()->json(['message' => 'Data Motor tidak ditemukan!'], 404);
        }
        return new MotorResource(true, 'Detail Data Motor', $motor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $motor = Motor::find($id);

        if(!$motor){
            return response()->json(['message' => 'Data Motor tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'plat_nomor'    => 'unique:motors,plat_nomor',
            'tahun_produksi' => 'integer',
            'harga_sewa'    => 'numeric',
            'status'        => 'in:tersedia,disewa,maintenance',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/motors', $gambar->hashName());

            if ($motor->gambar) {
                Storage::delete('public/motors/' . $motor->gambar);
            }

            $motor->update(array_merge(
                $request->all(),
                ['gambar' => $gambar->hashName()]
            ));
        } else {
            $motor->update($request->all());
        }

        return new MotorResource(true, 'Data Motor Berhasil Diubah!', $motor);
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
        return new MotorResource(true, 'Data Motor Berhasil Dihapus!', null);
    }
}
