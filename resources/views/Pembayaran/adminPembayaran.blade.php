@extends('app') 
@section('content')
<div class="container py-5" style="margin-top: 80px">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" style="color: #5da898">Verifikasi Pembayaran Masuk</h5>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Penyewa</th>
                            <th width="20%">Kendaraan</th>
                            <th width="20%">Total & Bukti</th>
                            <th width="15%">Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayaran as $key => $item)
                        <tr>
                            <td>{{ $pembayaran->firstItem() + $key }}</td>
                            
                            <td>
                                <div class="fw-bold text-dark">{{ $item->peminjaman->user->name ?? 'User Hilang' }}</div>
                                <span class="badge bg-light text-secondary border mt-1">
                                    {{ strtoupper($item->metode) }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-bold">{{ $item->peminjaman->kendaraan->nama ?? '-' }}</div>
                                <small class="text-muted">{{ $item->peminjaman->kendaraan->plat_nomor ?? '-' }}</small>
                            </td>

                            <td>
                                <div class="fw-bold text-success">
                                    Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-info mt-2 w-100" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}">
                                    <i class="bi bi-eye-fill"></i> Lihat Detail
                                </button>
                            </td>
                            <td>
                                @if($item->status == 'menunggu_verifikasi' || $item->status == 'pending')
                                    <span class="badge bg-warning text-dark">Perlu Cek</span>
                                @elseif($item->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
  
                                @if($item->status == 'pending')
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.pembayaran.verify', $item->id) }}" method="POST" onsubmit="return confirm('Yakin Terima?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="lunas">
                                            <button type="submit" class="btn btn-success btn-sm" title="Terima">
                                                Terima
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.pembayaran.verify', $item->id) }}" method="POST" onsubmit="return confirm('Yakin Tolak?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="dibatalkan"> {{-- Sesuaikan value database --}}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @elseif($item->status == 'dibatalkan' || $item->status == 'ditolak')
                                    <form action="{{ route('admin.pembayaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                @else
                                    <small class="text-muted"><i class="bi bi-check-circle-fill text-success"></i> Selesai</small>
                                @endif

                                <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title fw-bold text-secondary">
                                                    <i class="bi bi-receipt me-2"></i>Detail Transaksi #{{ $item->id }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-md-5 mb-3">
                                                        <div class="card h-100 border-0 bg-light">
                                                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                                                <h6 class="text-muted mb-3">Bukti Transfer</h6>
                                                                @if($item->bukti)
                                                                    <div class="ratio ratio-1x1 mb-3">
                                                                        <img src="{{ asset('storage/' . $item->bukti) }}" class="rounded object-fit-cover" alt="Bukti">
                                                                    </div>
                                                                    <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                        <i class="bi bi-zoom-in"></i> Perbesar Gambar
                                                                    </a>
                                                                @else
                                                                    <div class="text-muted py-5">
                                                                        <i class="bi bi-image-alt fs-1 d-block mb-2"></i>
                                                                        Tidak ada gambar
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <h6 class="fw-bold border-bottom pb-2 mb-3">Rincian Sewa</h6>
                                                        
                                                        <table class="table table-sm table-borderless">
                                                            <tr>
                                                                <td class="text-secondary" width="40%">Nama Penyewa</td>
                                                                <td class="fw-bold">{{ $item->peminjaman->user->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-secondary">Unit Mobil</td>
                                                                <td>{{ $item->peminjaman->kendaraan->nama}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-secondary">Plat Nomor</td>
                                                                <td><span class="badge bg-light text-dark border">{{ $item->peminjaman->kendaraan->plat_nomor ?? '-' }}</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-secondary">Tanggal Sewa</td>
                                                                <td>
                                                                    {{ date('d M', strtotime($item->peminjaman->tanggal_pinjam)) }} - 
                                                                    {{ date('d M Y', strtotime($item->peminjaman->tanggal_kembali)) }}
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <h6 class="fw-bold border-bottom pb-2 mb-3 mt-4">Rincian Pembayaran</h6>
                                                        <table class="table table-sm table-borderless">
                                                            <tr>
                                                                <td class="text-secondary" width="40%">Metode</td>
                                                                <td>{{ strtoupper($item->metode) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-secondary">Waktu Upload</td>
                                                                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                                            </tr>
                                                            <tr class="table-success">
                                                                <td class="fw-bold text-success ps-2">Total Bayar</td>
                                                                <td class="fw-bold text-success fs-5">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer bg-light border-0">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">Belum ada data pembayaran masuk hari ini.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $pembayaran->links() }}
            </div>
        </div>
    </div>
</div>
@endsection