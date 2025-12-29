<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    //
    use HasFactory;
    protected $table = 'pembayarans';

    protected $fillable = [
        'nama_pengirim',
        'metode_pembayaran',
        'jumlah_bayar',
        'bukti_bayar',
        'status',
    ];
}
