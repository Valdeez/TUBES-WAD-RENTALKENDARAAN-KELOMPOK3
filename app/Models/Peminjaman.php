<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $fillable = [
        "user_id",
        "tanggal_pinjam",
        "tanggal_kembali",
        "durasi",
        "status",
    ];

    public function user()
    {
        // return $this->belongsTo(User::class);
        return null;
    }

    public function kendaraan()
    {
        return $this->morphTo();
    }
}
