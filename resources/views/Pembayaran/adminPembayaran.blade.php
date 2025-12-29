@extends('app') 
@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Verifikasi Pembayaran Masuk</h5>
        </div>
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Penyewa</th>
                            <th>Info Mobil</th>
                            <th>Bukti & Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayaran as $key => $item)
                        <tr>
                            <td>{{ $pembayaran->firstItem() + $key }}</td>
                            
                            <td>
                                <strong>{{ $item->peminjaman->user->name ?? 'User Hilang' }}</strong><br>
                                <span class="badge bg-secondary">{{ strtoupper($item->metode) }}</span>
                            </td>

                            <td>
                                {{ $item->peminjaman->kendaraan->merk ?? '-' }} <br>
                                <small class="text-muted">{{ $item->peminjaman->kendaraan->nopol ?? '-' }}</small>
                            </td>

                            <td>
                                <div class="fw-bold text-success">
                                    Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}
                                </div>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        Lihat Foto
                                    </a>
                                </div>
                            </td>

                            <td>
                                @if($item->status == 'menunggu_verifikasi')
                                    <span class="badge bg-warning text-dark">Perlu Cek</span>
                                @elseif($item->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>

                            <td>
                                @if($item->status == 'menunggu_verifikasi')
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.pembayaran.verify', $item->id) }}" method="POST" onsubmit="return confirm('Terima pembayaran?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="lunas">
                                            <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                        </form>
                                        <form action="{{ route('admin.pembayaran.verify', $item->id) }}" method="POST" onsubmit="return confirm('Tolak pembayaran?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <small class="text-muted">Selesai</small>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $pembayaran->links() }}
            </div>
        </div>
    </div>
</div>
@endsection