<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'plat_nomor',
        'merk',
        'tipe',
        'tahun_produksi',
        'warna',
        'harga_sewa',
        'status',
        'gambar',
    ];
}
