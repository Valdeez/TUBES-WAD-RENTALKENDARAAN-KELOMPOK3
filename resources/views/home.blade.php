@extends('app')

@push('styles')
<style>
    .hero-section {
        padding: 250px 0 100px 0;
        background-color: #f8f9fa;
    }

    .hero-title {
        font-weight: 700;
        font-size: 3.5rem;
        color: #333;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .hero-desc {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .hero-img {
        max-width: 100%;
        height: auto;
        filter: drop-shadow(0 15px 15px rgba(0, 0, 0, 0.2));
    }

    .section-title {
        font-weight: 700;
        font-size: 3rem;
        color: #333;
        margin-top: 50px;
    }

    .vehicle-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        background: #fff;
        overflow: hidden;
    }

    .vehicle-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .vehicle-img-wrapper {
        height: 180px;
        background-color: #f1f1f1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .vehicle-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .vehicle-info {
        padding: 20px;
        text-align: center;
    }

    .vehicle-name {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 5px;
        color: #333;
    }

    .vehicle-type {
        color: #888;
        font-size: 0.9rem;
        margin-bottom: 20px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-block {
        display: block;
        width: 100%;
    }
</style>
@endpush

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="hero-title">
                    Sewa Mobil & Motor <br>
                    Dengan Harga <br>
                    Terjangkau
                </h1>
                <p class="hero-desc">
                    Nikmati perjalanan tanpa repot dengan armada terbaik kami. <br>
                    Proses booking cepat, unit bersih terawat, dan siap menemani <br>
                    liburan maupun perjalanan bisnis Anda kapan saja.
                </p>
                <a href="#kendaraan" class="btn btn-teal-fill btn-lg px-4 py-2">Lihat Kendaraan</a>
            </div>

            <div class="col-md-6 text-center">
                <img src="{{ asset('hero.png') }}" alt="Mobil Rental" class="hero-img">
            </div>
        </div>
    </div>
</section>

<section class="container mb-5" id="kendaraan">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="section-title">Mobil Kami</h1>
            <p class="hero-desc">Tersedia banyak pilihan mobil bersih dan nyaman, siap temani semua rute perjalanan kamu</p>
        </div>
        @foreach ($mobils as $mobil)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card vehicle-card">
                    <div class="vehicle-img-wrapper">
                        <img src="{{ asset('storage/'.$mobil->gambar) }}" class="vehicle-img" alt="{{ $mobil->nama }}">
                    </div>
                    <div class="vehicle-info">
                        <h3 class="vehicle-name">{{ $mobil->nama }}</h3>
                        <span class="vehicle-type">{{ $mobil->tipe }}</span>
                        <a href="{{ route('mobil.detail', $mobil->id) }}" class="btn btn-teal-outline btn-block mt-2">Sewa Sekarang</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="container mb-5">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="section-title">Motor Kami</h1>
            <p class="hero-desc">Tersedia banyak pilihan motor bersih dan nyaman, siap temani semua rute perjalanan kamu</p>
        </div>
        @foreach ($motors as $motor)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card vehicle-card">
                    <div class="vehicle-img-wrapper">
                        <img src="{{ asset('storage/'.$motor->gambar) }}" class="vehicle-img" alt="{{ $motor->nama }}">
                    </div>
                    <div class="vehicle-info">
                        <h3 class="vehicle-name">{{ $motor->nama }}</h3>
                        <span class="vehicle-type">{{ $motor->tipe }}</span>
                        <a href="{{ route('motor.detail', $motor->id) }}" class="btn btn-teal-outline btn-block mt-2">Sewa Sekarang</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection