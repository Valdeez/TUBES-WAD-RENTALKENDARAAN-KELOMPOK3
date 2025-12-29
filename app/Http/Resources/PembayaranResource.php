<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PembayaranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
        'id' => $this->id,
        'nama_pengirim' => $this->nama_pengirim,
        'metode_pembayaran' => $this->metode_pembayaran,
        'jumlah_bayar' => $this->jumlah_bayar,
        'status' => $this->status,
        'bukti_bayar' => url('storage/' . $this->bukti_bayar),
        'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
