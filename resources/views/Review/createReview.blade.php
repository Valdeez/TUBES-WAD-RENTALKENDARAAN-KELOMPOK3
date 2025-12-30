@extends('app')

@section('content')
<style>
    .rating-wrapper {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
    }
    .rating-wrapper input { display: none; }
    .rating-wrapper label {
        cursor: pointer;
        width: 40px;
        height: 40px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23ccc' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100%;
        transition: .3s;
    }
    .rating-wrapper input:checked ~ label,
    .rating-wrapper label:hover,
    .rating-wrapper label:hover ~ label {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'/%3E%3C/svg%3E");
    }
</style>
<div class="container pt-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Beri Ulasan Kendaraan</h3>
                    <hr>
                    <div class="d-flex align-items-center p-3 mb-4 bg-light rounded border">
                        <img src="{{ asset('storage/' . $peminjaman->kendaraan->gambar) }}" class="rounded me-3" style="width: 100px;">
                        <div>
                            <h5 class="fw-bold mb-0">{{ $peminjaman->kendaraan->nama }}</h5>
                            <span class="badge bg-dark mb-2">{{ $peminjaman->kendaraan->plat_nomor }}</span>
                            <p class="small text-muted mb-0">
                                {{ $peminjaman->tgl_pinjam_formatted }} - {{ $peminjaman->tgl_kembali_formatted }}
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('review.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

                        <div class="mb-4 text-center">
                            <label class="form-label d-block fw-bold">Berikan Rating</label>
                            <div class="rating-wrapper">
                                <input type="radio" id="star5" name="rating" value="5" required/><label for="star5"></label>
                                <input type="radio" id="star4" name="rating" value="4"/><label for="star4"></label>
                                <input type="radio" id="star3" name="rating" value="3"/><label for="star3"></label>
                                <input type="radio" id="star2" name="rating" value="2"/><label for="star2"></label>
                                <input type="radio" id="star1" name="rating" value="1"/><label for="star1"></label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ulasan Anda</label>
                            <textarea name="comment" class="form-control" rows="4" placeholder="Apa yang Anda sukai dari kendaraan ini?" required></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-success px-4">Kirim Ulasan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection