@extends('app')

@section('content')
<section class="py-5" style="background-color: #f5f7fa; margin-top: 100px;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">Riwayat Peminjaman <br>
                <span class="text-muted fs-5 fw-normal">Lihat semua riwayat peminjaman disini</span>
            </h2>
            <a href="{{ url('/') }}" class="btn btn-teal-outline px-4 rounded">
                Sewa Lagi
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                @forelse($peminjamans as $item)
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden card-hover">
                        <div class="row g-0">
                            
                            <div class="col-md-4 col-lg-3 bg-light d-flex align-items-center justify-content-center position-relative" style="min-height: 200px;">
                                @if($item->kendaraan && $item->kendaraan->gambar)
                                    <img src="{{ asset('storage/' . $item->kendaraan->gambar) }}" 
                                         alt="Kendaraan" 
                                         class="w-100 h-100 position-absolute top-0 start-0"
                                         style="object-fit: contain;">
                                @else
                                    <div class="text-center text-muted p-4">
                                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                                        <small>Tidak ada gambar</small>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-8 col-lg-9">
                                <div class="card-body p-4 h-100 d-flex flex-column justify-content-between">
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h4 class="fw-bold text-dark mb-1">
                                                {{ $item->kendaraan->nama }}
                                            </h4>
                                            <span class="text-muted text-uppercase small letter-spacing-1">
                                                {{ $item->kendaraan->plat_nomor }} • {{ $item->kendaraan->warna }}
                                            </span>
                                        </div>
                                        
                                        @php
                                            $statusClass = match($item->status) {
                                                'disewa' => 'bg-warning text-dark',
                                                'selesai'  => 'bg-success text-white',
                                                'dibatalkan' => 'bg-danger text-white',
                                                default    => 'bg-secondary text-white'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 fw-normal">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>

                                    <div class="mb-4">
                                        <div class="d-flex align-items-center text-muted">
                                            <span class="me-3">Waktu Pinjam: <strong>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</strong></span>
                                            <span>Durasi: <strong>{{ $item->durasi }} Hari</strong></span>
                                        </div>
                                    </div>

                                    <hr class="border-light my-0 mb-3">

                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                                        <div class="mb-3 mb-sm-0">
                                            <small class="text-muted d-block">Total Biaya</small>
                                            <h4 class="fw-bold text-teal mb-0">
                                                @if($item->kendaraan)
                                                    Rp {{ number_format( (float)$item->kendaraan->harga_sewa * (int)$item->durasi, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </h4>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('peminjaman.show', $item->id) }}" class="btn btn-outline-secondary px-4">Lihat Detail</a>
                                            
                                            @if($item->status == 'disewa')
                                                <a href="" class="btn btn-teal-fill px-4 shadow-sm">
                                                    Bayar Sekarang
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="Empty" style="width: 200px; opacity: 0.6">
                        <h4 class="mt-4 text-muted">Belum ada riwayat sewa</h4>
                        <a href="{{ url('/') }}" class="btn btn-teal-fill mt-3">Mulai Menyewa</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .text-teal { color: #5da898; }
    .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
    .card-hover:hover { 
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }
    .object-fit-cover { object-fit: cover; }
    .letter-spacing-1 { letter-spacing: 1px; }
</style>
@endpush