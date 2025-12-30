<style>
    .star-css {
        inline-size: 18px;
        aspect-ratio: 1;
        background: #dee2e6;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        display: inline-block;
    }
    .star-css.filled {
        background: #ffc107;
    }
    .review-card-custom {
        border-left: 5px solid #54a692 !important;
        background-color: #f8f9fa;
    }
</style>

@foreach($reviews as $review)
    <div class="card review-card-custom border-0 shadow-sm mb-3">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="fw-semibold mb-1" style="color: #000000;">{{ $review->peminjaman->user->name }}</h6>
                    <div class="d-flex gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="star-css {{ $i <= $review->rating ? 'filled' : '' }}"></div>
                        @endfor
                    </div>
                </div>
                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
            </div>
            
            <p class="text-secondary mb-2" style="font-size: 0.9rem; line-height: 1.5;">
                "{{ $review->comment }}"
            </p>

            {{-- @if(auth()->id() == $review->peminjaman->user_id) --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('review.edit', $review->id) }}" class="btn btn-sm px-2 btn-outline-primary" style="font-size: 0.75rem;">Ubah Ulasan</a>
                    <form action="{{ route('review.destroy', $review->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm px-2 btn-outline-danger" style="font-size: 0.75rem;" onclick="return confirm('Hapus ulasan?')">Hapus Ulasan</button>
                    </form>
                </div>
            {{-- @endif --}}
        </div>
    </div>
@endforeach