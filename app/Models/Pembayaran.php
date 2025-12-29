<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'metode',
        'status',
        'bukti',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
