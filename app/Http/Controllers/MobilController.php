<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use App\Http\Resources\MobilResource; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class MobilController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobils = Mobil::latest()->get();
        return new MobilResource(true, 'List Data Mobil', $mobils);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'              => 'required',
            'plat_nomor'        => 'required|unique:mobils',
            'tipe'              => 'required',
            'tahun_produksi'    => 'required|integer',
            'warna'             => 'required',
            'harga_sewa'        => 'required|numeric',
            'status'            => 'required|in:tersedia,disewa,maintenance',
            'gambar'            => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
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
            'status'            => $request->status,
            'gambar'            => $imagePath,
        ]);
        return new MobilResource(true, 'Data Mobil Berhasil Ditambahkan!', $mobil);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mobil = Mobil::find($id);

        if(!$mobil){
            return response()->json(['message' => 'Data Mobil tidak ditemukan!'], 404);
        }
        return new MobilResource(true, 'Detail Data Mobil', $mobil);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mobil = Mobil::find($id);

        if(!$mobil){
            return response()->json(['message' => 'Data Mobil tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'plat_nomor'    => 'unique:mobils,plat_nomor',
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
            $gambar->storeAs('public/mobils', $gambar->hashName());

            if ($mobil->gambar) {
                Storage::delete('public/mobils/' . $mobil->gambar);
            }

            $mobil->update(array_merge(
                $request->all(),
                ['gambar' => $gambar->hashName()]
            ));
        } else {
            $mobil->update($request->all());
        }

        return new MobilResource(true, 'Data Mobil Berhasil Diubah!', $mobil);
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
        return new MobilResource(true, 'Data Mobil Berhasil Dihapus!', null);
    }
}