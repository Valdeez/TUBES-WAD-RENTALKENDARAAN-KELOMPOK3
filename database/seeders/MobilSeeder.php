<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Mobil;


class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Mobil::Create([
            'nama'              => 'Daihatsu Ayla',
            'plat_nomor'        => 'B2345XYZ',
            'tipe'              => 'Hatchback',
            'tahun_produksi'    => 2020,
            'warna'             => 'Putih',
            'harga_sewa'        => 150000,
            'gambar'            => 'mobils/daihatsu_ayla.png',
        ]);
        Mobil::Create([
            'nama'              => 'Toyota Avanza',
            'plat_nomor'        => 'B6789ABC',
            'tipe'              => 'MPV',
            'tahun_produksi'    => 2019,
            'warna'             => 'Silver',
            'harga_sewa'        => 200000,
            'gambar'            => 'mobils/toyota_avanza.png',
        ]);
        Mobil::Create([
            'nama'              => 'Honda Brio',
            'plat_nomor'        => 'B1011DEF',
            'tipe'              => 'Hatchback',
            'tahun_produksi'    => 2018,
            'warna'             => 'Merah',
            'harga_sewa'        => 180000,
            'gambar'            => 'mobils/honda_brio.png',
        ]);
        Mobil::Create([
            'nama'              => 'Suzuki Ertiga',
            'plat_nomor'        => 'B1314GHI',
            'tipe'              => 'MPV',
            'tahun_produksi'    => 2021,
            'warna'             => 'Hitam',
            'harga_sewa'        => 220000,
            'gambar'            => 'mobils/suzuki_ertiga.png',
        ]);
    }
}
