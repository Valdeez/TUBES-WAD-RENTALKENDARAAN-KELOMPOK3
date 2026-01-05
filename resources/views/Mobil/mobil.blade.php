@extends('app')

@push('styles')
<style>
    /* Styling Section Judul & Subjudul */
    .section-header {
        text-align: center;
        margin-bottom: 50px;
        margin-top: 120px;
    }

    .section-title {
        font-weight: 700;
        color: #333;
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .section-subtitle {
        color: #666;
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Styling Card Kendaraan */
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
        /* Tinggi gambar tetap agar rapi */
        background-color: #fafafa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .vehicle-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        /* Agar gambar memenuhi kotak */
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

    /* Menggunakan class btn-teal-outline yang sudah ada di app.blade.php */
    .btn-block {
        display: block;
        width: 100%;
    }
</style>
@endpush

@section('content')


<section class="container mb-5 mt-5">
   @if(session('success'))
    <div id="auto-close-alert" class="alert alert-success alert-dismissible fade show shadow" role="alert" 
         style="position: absolute; top: 100px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 80%; max-width: 800px;">
        
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        // Tunggu dokumen selesai dimuat
        document.addEventListener("DOMContentLoaded", function() {
            // Cari elemen alert
            var alertElement = document.getElementById('auto-close-alert');
            
            // Jika alert ada
            if (alertElement) {
                // Set waktu tunggu 2 detik (2000 milidetik)
                setTimeout(function() {
                    // Cari tombol close di dalam alert dan klik otomatis
                    var closeButton = alertElement.querySelector('.btn-close');
                    if (closeButton) {
                        closeButton.click();
                    }
                }, 2000); // <-- Ganti angka ini jika ingin lebih lama/cepat
            }
        });
    </script>
@endif
    <div class="section-header">
        <h2 class="section-title">Daftar Mobil</h2>
        <p class="section-subtitle">Tersedia banyak pilihan mobil bersih dan nyaman, siap temani semua rute perjalanan kamu</p>
    </div>

    <div class="row">
        @if(Auth::check() && Auth::user()->role == 'admin')
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card vehicle-card h-100 border-2 border-dashed d-flex align-items-center justify-content-center" 
                 style="background-color: #f8f9fa; border-style: dashed !important; border-color: #5da898; min-height: 380px; cursor: pointer;"
                 onclick="window.location='{{ route('mobil.create') }}'">
                
                <div class="text-center">
                    <div style="width: 80px; height: 80px; background: #5da898; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <span style="font-size: 40px; color: #fafafa; line-height: 1;">+</span>
                    </div>
                    <h5 class="text-muted fw-bold">Tambah Mobil</h5>
                </div>
            </div>
        </div>
        @endif

        @foreach ($mobils as $mobil)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card vehicle-card">
                    <div class="vehicle-img-wrapper">
                        <img src="{{ asset('storage/'.$mobil->gambar) }}" class="vehicle-img" alt="Mobil">
                    </div>
                    <div class="vehicle-info">
                        <h3 class="vehicle-name">{{ $mobil->nama }}</h3>
                        <span class="vehicle-type">{{ $mobil->tipe }}</span>
                        <a href="{{ route('mobil.detail', $mobil->id) }}" class="btn btn-teal-outline btn-block mt-2">Lihat Detail</a>
                        @if($mobil->status == 'tersedia')
                            <a href="{{ route('peminjaman.create', [$mobil->id, 'mobil']) }}" class="btn btn-teal-fill btn-block mt-2">Sewa Sekarang</a>
                        @else
                            {{-- Jika tidak tersedia, tombol jadi abu-abu (secondary) & disabled --}}
                            <button class="btn btn-secondary btn-block mt-2 text-capitalize" disabled>
                                {{ $mobil->status == 'disewa' ? 'Sedang Disewa' : 'Maintenance' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection

