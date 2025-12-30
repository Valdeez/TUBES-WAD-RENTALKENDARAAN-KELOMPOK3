@extends('app')

@section('content')
<div class="container" style="margin-top: 150px; margin-bottom: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 fw-bold text-dark">Tambah Motor Baru</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('motor.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Motor</label>
                                <input type="text" name="nama" class="form-control" placeholder="Contoh: Honda Vario 150" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipe / Kategori</label>
                                <input type="text" name="tipe" class="form-control" placeholder="Contoh: Matic / Sport" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Plat Nomor</label>
                                <input type="text" name="plat_nomor" class="form-control" placeholder="Contoh: D 1234 ABC" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Warna</label>
                                <input type="text" name="warna" class="form-control" placeholder="Contoh: Hitam" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Produksi</label>
                                <input type="number" name="tahun_produksi" class="form-control" placeholder="Contoh: 2024">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Sewa (Per Hari)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_sewa" class="form-control" placeholder="100000" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Upload Gambar Motor</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('motor.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-teal-fill px-5">Simpan Data</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-teal-fill {
        background-color: #5da898;
        color: white;
        border: none;
    }
    .btn-teal-fill:hover {
        background-color: #1aa179;
        color: white;
    }
</style>
@endsection