<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PembayaranResource;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayarans = Pembayaran::latest()->get();
        return PembayaranResource::collection($pembayarans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_pengirim'     => 'required|string|max:255',
            'metode_pembayaran' => 'required|string',
            'jumlah_bayar'      => 'required|integer|min:1',
            'bukti_bayar'       => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => 'Tolong di Periksa kembali',
                'errors' => $validator->errors()
            ], 422);
        }

       
        $imagePath = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');

        $pembayaran = Pembayaran::create([
            'nama_pengirim'     => $request->nama_pengirim,
            'metode_pembayaran' => $request->metode_pembayaran,
            'jumlah_bayar'      => $request->jumlah_bayar,
            'bukti_bayar'       => $imagePath, // Simpan alamatnya
            'status'            => 'pending'
        ]);

        return (new PembayaranResource($pembayaran))
                ->additional(['message' => 'Pembayaran telah berhasil'])
                ->response()
                ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::find($id);
        
        if(!$pembayaran) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }
        
        return new PembayaranResource($pembayaran);
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, $id) 
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran){
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(),[
            'nama_pengirim'     => 'required|string|max:255',
            'metode_pembayaran' => 'required|string',
            'jumlah_bayar'      => 'required|integer|min:1',
            'bukti_bayar'       => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'status'            => 'required|in:pending,lunas,gagal',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Tolong periksa kembali',
                'errors' => $validator->errors()
            ], 422);
        }

        
        $dataUpdate = [
            'nama_pengirim'     => $request->nama_pengirim,
            'metode_pembayaran' => $request->metode_pembayaran,
            'jumlah_bayar'      => $request->jumlah_bayar,
            'status'            => $request->status,
        ];

        
        if ($request->hasFile('bukti_bayar')) {
            
            if ($pembayaran->bukti_bayar) {
                Storage::disk('public')->delete($pembayaran->bukti_bayar);
            }
           
            $pathBaru = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');
            $dataUpdate['bukti_bayar'] = $pathBaru;
        }

        
        $pembayaran->update($dataUpdate);

        return (new PembayaranResource($pembayaran))
                ->additional(['message' => 'Pembayaran berhasil di update'])
                ->response()
                ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
   
    public function destroy($id)
    {
       $pembayaran = Pembayaran::find($id);

       if (!$pembayaran){
        return response()->json(['message' => 'pembayaran tidak ditemukan'], 404);
       }

       if ($pembayaran->bukti_bayar) {
           Storage::disk('public')->delete($pembayaran->bukti_bayar);
       }

       $pembayaran->delete();

       return response()->json(['message' => 'Pembayaran berhasil didelete'], 200);
    }
}