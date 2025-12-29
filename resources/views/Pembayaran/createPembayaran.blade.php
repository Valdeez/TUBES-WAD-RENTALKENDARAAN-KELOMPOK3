@extends('app')

@push('styles')
<style>
    .payment-section {
        padding-top: 100px;
        padding-bottom: 50px;
        margin-top: 50px;
    }
    
    .summary-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border: none;
        position: sticky;
        top: 100px;
    }
    .summary-img {
        width: 100%;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }
    .summary-content {
        padding: 20px;
    }
    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        color: #666;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed #ddd;
        font-weight: 700;
        font-size: 1.2rem;
        color: #333;
    }

    
    .payment-method-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
    }
    .payment-method-card:hover {
        border-color: #5da898;
        background-color: #f0fdfa;
    }

    .form-check-input:checked + .payment-method-label .payment-method-card {
        border-color: #5da898;
        background-color: #f0fdfa;
        box-shadow: 0 0 0 1px #5da898;
    }
    
    .bank-logo {
        width: 60px;
        height: auto;
        margin-right: 15px;
        object-fit: contain;
    }
    .bank-details {
        flex: 1;
    }
    .bank-name {
        font-weight: 600;
        color: #333;
        display: block;
    }
    .bank-number {
        font-size: 0.9rem;
        color: #666;
    }
    .payment-accordion .accordion-item {
        border: 1px solid #eee;
        border-radius: 8px !important;
        margin-bottom: 10px;
        overflow: hidden;
    }
    
    .payment-accordion .accordion-button {
        font-weight: 600;
        color: #333;
        background-color: #fff;
        box-shadow: none; 
    }

    .payment-accordion .accordion-button:not(.collapsed) {
        color: #0f766e; 
        background-color: #f0fdfa; 
        box-shadow: none;
        border-bottom: 1px solid #e5e7eb;
    }

    .payment-accordion .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }

    .bank-logo-small {
        height: 24px;
        margin-right: 10px;
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="container payment-section">
    <div class="row">
        <h2 class="mb-4 fw-bold">Pembayaran</h2>
        <div class="col-lg-8 mb-4">
            
            <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">Informasi Penyewa</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $peminjaman->user->name ?? 'Nama User' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" value="{{ $peminjaman->user->phone }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">Pilih Metode Transfer</h5>
                        
                        <div class="accordion payment-accordion" id="accordionPayment">
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingBCA">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBCA" aria-expanded="true" aria-controls="collapseBCA">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" class="bank-logo-small" alt="BCA">
                                        Transfer Bank BCA
                                    </button>
                                </h2>
                                <div id="collapseBCA" class="accordion-collapse collapse show" aria-labelledby="headingBCA" data-bs-parent="#accordionPayment">
                                    <div class="accordion-body bg-light">
                                        <input type="radio" name="metode" value="bca" class="d-none payment-radio" checked>
                                        
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-1 fw-bold">PT. Rent Vehicle 3!</p>
                                                <p class="mb-0 text-muted font-monospace fs-5">8830-1234-5678</p>
                                                <small class="text-success"><i class="bi bi-check-circle-fill"></i> Salin Nomor Rekening</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingMandiri">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMandiri" aria-expanded="false" aria-controls="collapseMandiri">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/1200px-Bank_Mandiri_logo_2016.svg.png" class="bank-logo-small" alt="Mandiri">
                                        Transfer Bank Mandiri
                                    </button>
                                </h2>
                                <div id="collapseMandiri" class="accordion-collapse collapse" aria-labelledby="headingMandiri" data-bs-parent="#accordionPayment">
                                    <div class="accordion-body bg-light">
                                        <input type="radio" name="metode" value="mandiri" class="d-none payment-radio">
                                        
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-1 fw-bold">PT. Rent Vehicle 3!</p>
                                                <p class="mb-0 text-muted font-monospace fs-5">123-00-9876543-2</p>
                                                <small class="text-success"><i class="bi bi-check-circle-fill"></i> Salin Nomor Rekening</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Upload Bukti Transfer</h5>
                        <p class="text-muted small">Silakan transfer sesuai total nominal, lalu upload bukti transfer di sini.</p>
                        
                        <div class="mb-3">
                            <label for="proof" class="form-label">File Gambar (JPG/PNG)</label>
                            <input class="form-control" type="file" id="proof" name="bukti" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">
                <input type="hidden" name="jumlah_bayar" value="{{ $totalBayar }}">

                <button type="submit" class="btn btn-teal-fill btn-lg w-100 py-3 fw-bold">Konfirmasi Pembayaran</button>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card summary-card">
                <img src="{{ asset('storage/'.$peminjaman->kendaraan->gambar) }}" class="summary-img" alt="Mobil">
                <div class="summary-content">
                    <h5 class="fw-bold mb-1">{{ $peminjaman->kendaraan->nama }}</h5>
                    <p class="text-muted small mb-3">Tipe: {{ $peminjaman->kendaraan->plat_nomor }} - {{ $peminjaman->kendaraan->warna }}</p>
                    <hr>
                    
                    <div class="price-row">
                        <span>Harga Sewa / Hari</span>
                        <span class="fw-semibold">Rp {{ number_format($peminjaman->kendaraan->harga_sewa, 0, ',', '.') }}</span>
                    </div>
                    <div class="price-row">
                        <span>Durasi Sewa</span>
                        <span class="fw-semibold">{{ $peminjaman->durasi }} Hari</span>
                    </div>
                    <div class="price-row">
                        <span>Tanggal Mulai</span>
                        <span>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</span>
                    </div>
                    <div class="price-row">
                        <span>Tanggal Selesai</span>
                        <span>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</span>
                    </div>

                    <div class="total-row">
                        <span>Total Bayar</span>
                        <span style="color: #5da898;">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection