<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Rent Vehicle <span class="active">3!</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Mobil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Motor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pemesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pembayaran</a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="#" class="btn btn-teal-outline me-2">Masuk</a>
                <a href="#" class="btn btn-teal-fill">Daftar</a>
            </div>
        </div>
    </div>
</nav>