@extends('app')

@push('styles')
<style>
    .sewa-section {
        padding: 150px 0;
    }
    .card-detail {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .vehicle-image-container {
        background-color: #f1f1f1;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .vehicle-image {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }
    .price-tag {
        font-size: 1.5rem;
        font-weight: 700;
        color: #5da898;
    }
    .form-label {
        font-weight: 600;
        color: #333;
    }
    .total-price-box {
        background-color: #eaf6f4;
        border: 1px dashed #5da898;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }
</style>
@endpush

@section('content')
<section class="sewa-section container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="mb-4 fw-bold text-center">Formulir Sewa kendaraan</h2>
            
            <div class="card card-detail">
                <div class="row g-0">
                    <div class="col-md-5 border-end">
                        <div class="vehicle-image-container">
                            <img src="{{ asset('storage/'.$kendaraan->gambar) }}" alt="{{ $kendaraan->nama ?? 'kendaraan' }}" class="vehicle-image">
                        </div>
                        <div class="p-4">
                            <h3 class="fw-bold mb-1">{{ $kendaraan->nama ?? 'Nama kendaraan' }}</h3>
                            <p class="text-muted text-uppercase mb-3">{{ $kendaraan->tipe ?? 'Tipe kendaraan' }}</p>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Harga Sewa / Hari</span>
                                <span class="price-tag">Rp {{ number_format($kendaraan->harga_sewa ?? 100000, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="mt-3">
                                <small class="text-muted d-block mb-1">Plat Nomor: <strong>{{ $kendaraan->plat_nomor ?? 'B 1234 CD' }}</strong></small>
                                <small class="text-muted d-block">Tahun Produksi: <strong>{{ $kendaraan->tahun_produksi ?? '2020' }}</strong></small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="p-5">
                            <h4 class="fw-bold mb-4">Lengkapi Data Peminjaman</h4>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('peminjaman.store') }}" method="POST">
                                @csrf
                                
                                <input type="hidden" name="kendaraan_type" value="{{ $type }}">
                                <input type="hidden" name="kendaraan_id" value="{{ $kendaraan->id }}">

                                <div class="mb-3">
                                    <label for="tanggal_pinjam" class="form-label">Tanggal Mulai Sewa</label>
                                    <input type="date" 
                                           class="form-control form-control-lg @error('tanggal_pinjam') is-invalid @enderror" 
                                           id="tanggal_pinjam" 
                                           name="tanggal_pinjam" 
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                    @error('tanggal_pinjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="durasi" class="form-label">Durasi Sewa (Hari)</label>
                                    <input type="number" 
                                           class="form-control form-control-lg @error('durasi') is-invalid @enderror" 
                                           id="durasi" 
                                           name="durasi" 
                                           placeholder="Contoh: 3" 
                                           min="1" 
                                           required 
                                           oninput="hitungTotal()">
                                    @error('durasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="total-price-box d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-secondary">Estimasi Total Biaya</span>
                                    <span class="fs-4 fw-bold text-dark" id="totalBayar">Rp 0</span>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-teal-fill btn-lg">Konfirmasi Sewa</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function hitungTotal() {
        const hargaPerHari = {{ $kendaraan->harga_sewa ?? 100000 }};
        const durasi = document.getElementById('durasi').value;
        const totalSpan = document.getElementById('totalBayar');
        
        if(durasi > 0) {
            const total = hargaPerHari * durasi;
            totalSpan.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        } else {
            totalSpan.innerText = 'Rp 0';
        }
    }
</script>
@endsection