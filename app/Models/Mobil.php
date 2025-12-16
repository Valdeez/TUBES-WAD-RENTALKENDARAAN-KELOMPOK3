<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'plat_nomor',
        'tipe',
        'tahun_produksi',
        'warna',
        'harga_sewa',
        'status',
        'gambar',
    ];
}