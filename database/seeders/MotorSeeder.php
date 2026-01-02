<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Motor;


class MotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Motor::Create([
            'nama'              => 'Yamaha Aerox 155',
            'plat_nomor'        => 'B1234XYZ',
            'tipe'              => 'Matic',
            'tahun_produksi'    => 2020,
            'warna'             => 'Hitam Merah',
            'harga_sewa'        => 150000,
            'gambar'            => 'motors/yamaha_aerox_155.png',
        ]);
        Motor::Create([
            'nama'              => 'Yamaha R25',
            'plat_nomor'        => 'B5678ABC',
            'tipe'              => 'Sport',
            'tahun_produksi'    => 2019,
            'warna'             => 'Hitam',
            'harga_sewa'        => 200000,
            'gambar'            => 'motors/yamaha_r25.png',
        ]);
        Motor::Create([
            'nama'              => 'Yamaha NMAX',
            'plat_nomor'        => 'B9101DEF',
            'tipe'              => 'Matic',
            'tahun_produksi'    => 2014,
            'warna'             => 'Abu Abu',
            'harga_sewa'        => 180000,
            'gambar'            => 'motors/yamaha_nmax.png',
        ]);
        Motor::Create([
            'nama'              => 'Yamaha Vario 150',
            'plat_nomor'        => 'B1213GHI',
            'tipe'              => 'Matic',
            'tahun_produksi'    => 2020,
            'warna'             => 'Putih',
            'harga_sewa'        => 150000,
            'gambar'            => 'motors/yamaha_vario_150.png',
        ]);
    }
}
