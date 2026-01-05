@extends('app')

@section('content')
<style>
    .rating-wrapper { display: flex; flex-direction: row-reverse; justify-content: center; }
    .rating-wrapper input { display: none; }
    .rating-wrapper label {
        cursor: pointer; width: 40px; height: 40px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23ccc' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-size: 100%; transition: .3s;
    }
    .rating-wrapper input:checked ~ label, .rating-wrapper label:hover, .rating-wrapper label:hover ~ label {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'/%3E%3C/svg%3E");
    }
</style>

<div class="container pt-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Ubah Ulasan</h3>
                    <hr>
                    <div class="d-flex align-items-center p-3 mb-4 bg-light rounded border">
                        <img src="{{ asset('storage/' . $review->peminjaman->kendaraan->gambar) }}" class="rounded me-3" style="width: 100px;">
                        <div>
                            <h5 class="fw-bold mb-0">{{ $review->peminjaman->kendaraan->nama }}</h5>
                            <span class="badge bg-dark mb-2">{{ $review->peminjaman->kendaraan->plat_nomor }}</span>
                            <p class="small text-muted mb-0">
                                {{ $review->peminjaman->tgl_pinjam_formatted }} - {{ $review->peminjaman->tgl_kembali_formatted }}
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('review.update', $review->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 text-center">
                            <label class="form-label d-block fw-bold">Berikan Rating Baru</label>
                            <div class="rating-wrapper">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                           {{ $review->rating == $i ? 'checked' : '' }} required/>
                                    <label for="star{{ $i }}"></label>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ulasan Anda</label>
                            <textarea name="comment" class="form-control" rows="5" required>{{ old('comment', $review->comment) }}</textarea>
                            @error('comment') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-5" style="background-color: #54a692; border: none;">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection