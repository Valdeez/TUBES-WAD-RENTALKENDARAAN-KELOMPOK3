@extends('app')

@section('content')
<style>
    .star-css {
        inline-size: 16px;
        aspect-ratio: 1;
        background: #dee2e6;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        display: inline-block;
    }
    .star-css.filled {
        background: #ffc107;
    }
</style>
<section class="py-5" style="background-color: #f5f7fa; margin-top: 100px;">
    <div class="container">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-teal-outline text-decoration-none mb-4">
            Kembali ke Riwayat
        </a>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        @if($peminjaman->kendaraan && $peminjaman->kendaraan->gambar)
                            <img src="{{ asset('storage/' . $peminjaman->kendaraan->gambar) }}" 
                                 alt="Kendaraan" 
                                 class="w-100 h-100"
                                 style="object-fit: cover;">
                        @else
                            <div class="text-center text-muted">
                                <i class="bi bi-image fs-1"></i>
                                <p class="mb-0">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-1">{{ $peminjaman->kendaraan->nama }}</h3>
                        <p class="text-muted text-uppercase mb-4">
                            {{ $peminjaman->kendaraan->tipe }}
                        </p>

                        <h6 class="fw-bold text-dark mb-3">Spesifikasi Singkat</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Plat Nomor</span>
                                <span class="fw-semibold">{{ $peminjaman->kendaraan->plat_nomor }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Tahun Produksi</span>
                                <span class="fw-semibold">{{ $peminjaman->kendaraan->tahun_produksi }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Warna</span>
                                <span class="fw-semibold">{{ $peminjaman->kendaraan->warna }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Rincian Sewa</h4>
                        
                        @php
                            $statusClass = match($peminjaman->status) {
                                'pending' => 'bg-warning text-white',
                                'disewa' => 'bg-info text-white',
                                'selesai'  => 'bg-success text-white',
                                'dibatalkan' => 'bg-danger text-white',
                                default    => 'bg-secondary text-white'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 fs-6">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <small class="text-muted d-block mb-1">Tanggal Mulai</small>
                                <span class="fw-bold text-dark fs-5">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <small class="text-muted d-block mb-1">Tanggal Kembali</small>
                                <span class="fw-bold text-dark fs-5">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">Rincian Biaya</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted ps-0">Harga Sewa per Hari</td>
                                    <td class="text-end fw-semibold">
                                        Rp {{ number_format((float)($peminjaman->kendaraan->harga_sewa ?? 0), 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Durasi</td>
                                    <td class="text-end fw-semibold">{{ $peminjaman->durasi }} Hari</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="ps-0 pt-3 fs-5 fw-bold text-dark">Total Biaya</td>
                                    <td class="text-end pt-3 fs-4 fw-bold text-teal">
                                        Rp {{ number_format( (float)($peminjaman->kendaraan->harga_sewa ?? 0) * (int)$peminjaman->durasi, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-0 d-grid gap-3">
                        @if(!$peminjaman->pembayaran)
                            <a href="{{ route('pembayaran.create', $peminjaman->id) }}" class="btn btn-teal-fill btn-lg">
                                Lanjutkan Pembayaran
                            </a>
                        @elseif($peminjaman->status == 'pending')
                            <button class="btn btn-secondary btn-lg" disabled>
                                Menunggu Verifikasi
                            </button>
                        @elseif($peminjaman->status == 'disewa')
                            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST" class="d-grid">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-teal-fill btn-lg" onclick="return confirm('Apakah Anda yakin ingin mengembalikan kendaraan ini?')">
                                    Selesaikan Sewa
                                </button>
                            </form>
                        @elseif($peminjaman->status == 'selesai' && !$peminjaman->review)
                            <a href="{{ route('review.create', $peminjaman->id) }}" class="btn btn-teal-fill btn-lg">
                                Tambahkan Review
                            </a>
                        @endif
                        
                        @if ($peminjaman->status == 'dibatalkan' || $peminjaman->status == 'selesai')
                            <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-grid">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-lg" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
                                    Hapus Riwayat
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @if($peminjaman->review)
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Ulasan Anda</h5>
                            <div class="p-3 bg-light rounded-3" style="border-left: 5px solid #54a692;">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex gap-1 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="star-css {{ $i <= $peminjaman->review->rating ? 'filled' : '' }}"></div>
                                        @endfor
                                    </div>
                                    <small class="text-muted">{{ $peminjaman->review->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 text-secondary">"{{ $peminjaman->review->comment }}"</p>                                        
                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('review.edit', $peminjaman->review->id) }}" class="btn btn-sm btn-outline-primary" style="font-size: 0.75rem;">Ubah Ulasan</a>
                                    <form action="{{ route('review.destroy', $peminjaman->review->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm px-2 btn-outline-danger" style="font-size: 0.75rem;" onclick="return confirm('Hapus ulasan?')">Hapus Ulasan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .text-teal { color: #5da898; }
    .btn-teal-fill { 
        background-color: #5da898; 
        color: white; 
        border: none;
    }
    .btn-teal-fill:hover { 
        background-color: #4c8c7f; 
        color: white; 
    }
</style>
@endpush