@extends('app')

@section('content')
<div class="container" style="margin-top: 150px; margin-bottom: 80px;">
    
    <div class="mb-4">
        <a href="{{ route('motor') }}" class="btn btn-teal-outline">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Motor
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="row g-0">
                <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-5">
                    @if($motor->gambar)
                        <img src="{{ asset('storage/'.$motor->gambar) }}" class="img-fluid rounded" alt="{{ $motor->nama }}" style="max-height: 400px;">
                    @else
                        <img src="https://via.placeholder.com/400x300?text=No+Image" class="img-fluid rounded" alt="No Image">
                    @endif
                </div>

                <div class="col-md-6 p-5 position-relative">
                    
                    {{-- Tombol Edit & Hapus --}}
                    <div class="position-absolute top-0 end-0 m-4 d-flex gap-2" style="z-index: 10;">
                        <a href="{{ route('motor.edit', $motor->id) }}" class="btn btn-warning text-white btn-sm px-3 shadow-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('motor.destroy', $motor->id) }}" method="POST" onsubmit="return confirm('Yakin hapus motor ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm px-3 shadow-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>

                    <h5 class="text-muted text-uppercase letter-spacing-1 mt-2">{{ $motor->tipe }}</h5>
                    <h1 class="fw-bold text-dark mb-3">{{ $motor->nama }}</h1>
                    
                    <div class="mb-4">
                        <span class="fs-2 fw-bold text-success">
                            Rp {{ number_format($motor->harga_sewa, 0, ',', '.') }}
                        </span>
                        <span class="text-muted">/ hari</span>
                    </div>

                    <hr>

                    <div class="row mt-4 mb-4">
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">Tahun Produksi</small>
                            <span class="fw-bold">{{ $motor->tahun_produksi }}</span>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">Warna</small>
                            <span class="fw-bold">{{ $motor->warna }}</span>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">Plat Nomor</small>
                            <span class="badge bg-secondary">{{ $motor->plat_nomor }}</span>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">Status Unit</small>
                            @if($motor->status == 'tersedia')
                                <span class="badge bg-success">Tersedia</span>
                            @elseif($motor->status == 'disewa')
                                <span class="badge bg-warning text-dark">Sedang Disewa</span>
                            @else
                                <span class="badge bg-danger">Maintenance</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        {{-- LOGIKA BARU: Tombol Sewa --}}
                        @if($motor->status == 'tersedia')
                            {{-- Arahkan ke route peminjaman create --}}
                            <a href="{{ route('peminjaman.create', [$motor->id, 'motor']) }}" class="btn btn-teal-fill btn-block mt-2">Sewa Sekarang</a>
                        @else
                            {{-- Button disabled abu-abu jika status disewa/maintenance --}}
                            <button class="btn btn-secondary btn-lg text-capitalize" disabled>
                                {{ $motor->status == 'disewa' ? 'Unit Sedang Disewa' : 'Unit Sedang Maintenance' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection