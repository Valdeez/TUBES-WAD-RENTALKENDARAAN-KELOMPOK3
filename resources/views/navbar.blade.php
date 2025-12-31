<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Rent Vehicle <span class="active">3!</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::is('mobil.*') ? 'active' : '' }}" href="{{ route('mobil.index') }}">Mobil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::is('motor.*') ? 'active' : '' }}" href="{{ route('motor.index') }}">Motor</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::is('peminjaman.*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">Peminjaman</a>
                </li>
                {{-- @if(Auth::check() && Auth::user()->role == 'admin')  --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.pembayaran.*') ? 'active' : '' }}" href="{{ route('admin.pembayaran.index') }}">
                            Verifikasi
                        </a>
                    </li>
                {{-- @endif --}}
            </ul>
            <div class="d-flex">
                <a href="#" class="btn btn-teal-outline me-2">Masuk</a>
                <a href="#" class="btn btn-teal-fill">Daftar</a>
            </div>
        </div>
    </div>
</nav>