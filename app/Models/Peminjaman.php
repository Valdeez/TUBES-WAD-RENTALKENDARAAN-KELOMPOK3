<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        "user_id",
        'kendaraan_id',
        'kendaraan_type',
        "tanggal_pinjam",
        "tanggal_kembali",
        "durasi",
        "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan()
    {
        return $this->morphTo();
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
