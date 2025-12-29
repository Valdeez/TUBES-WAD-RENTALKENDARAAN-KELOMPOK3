@extends('app')

@section('content')
<section class="py-5" style="background-color: #f5f7fa; margin-top: 100px;">
    <div class="container">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-teal-outline text-decoration-none mb-4">
            Kembali ke Riwayat
        </a>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
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
                                'disewa' => 'bg-warning text-dark',
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

                    <div class="mt-4 d-grid gap-2">
                        @if($peminjaman->status == 'disewa')
                            {{-- {{ route('pembayaran.create', $peminjaman->id) }} --}}
                            <a href="" class="btn btn-teal-fill btn-lg">
                                <i class="bi bi-credit-card me-2"></i> Lanjutkan Pembayaran
                            </a>
                        @endif

                        @if($peminjaman->status == 'selesai')
                            <button class="btn btn-secondary btn-lg" disabled>Transaksi Selesai</button>
                        @endif
                    </div>

                </div>
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