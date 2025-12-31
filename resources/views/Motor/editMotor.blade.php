@extends('app')

@section('content')
<div class="container" style="margin-top: 150px; margin-bottom: 80px;">
    <div class="card shadow-sm">
     <div class="card-header py-3" style="background-color: #5da898;">
       <h4 class="mb-0 fw-bold text-white">Edit Motor: {{ $motor->nama }}</h4>
     </div>
        <div class="card-body p-4">
            
            {{-- Form mengarah ke route update dengan method PUT --}}
            <form action="{{ route('motor.update', $motor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') 

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Motor</label>
                        <input type="text" name="nama" class="form-control" value="{{ $motor->nama }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipe</label>
                        <input type="text" name="tipe" class="form-control" value="{{ $motor->tipe }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" name="plat_nomor" class="form-control" value="{{ $motor->plat_nomor }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Warna</label>
                        <input type="text" name="warna" class="form-control" value="{{ $motor->warna }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tahun Produksi</label>
                        <input type="number" name="tahun_produksi" class="form-control" value="{{ $motor->tahun_produksi }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Sewa</label>
                        <input type="number" name="harga_sewa" class="form-control" value="{{ $motor->harga_sewa }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="tersedia" {{ $motor->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="disewa" {{ $motor->status == 'disewa' ? 'selected' : '' }}>Sedang Disewa</option>
                        <option value="maintenance" {{ $motor->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Ganti Gambar (Opsional)</label>
                    <input type="file" name="gambar" class="form-control">
                    @if($motor->gambar)
                        <small class="d-block mt-2">Gambar saat ini:</small>
                        <img src="{{ asset('storage/'.$motor->gambar) }}" width="100" class="rounded border">
                    @endif
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('motor.detail', $motor->id) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-teal-fill px-5">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection