<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Peminjaman;

class Motor extends Model
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
    public function peminjamans()
    {  
        return $this->morphMany(Peminjaman::class, 'kendaraan');
    }

}
