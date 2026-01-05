@extends('app')

@push('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
        }

        .card {
            width: 600px;
            margin: 100px auto;
            padding: 50px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1f2937;
        }

        input {
            width: 100%;
            padding: 11px;
            margin-top: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #5fb3a2;
            box-shadow: 0 0 0 2px rgba(95,179,162,0.2);
        }

        button {
            width: 100%;
            padding: 11px;
            margin-top: 16px;
            background: #5fb3a2;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        button:hover {
            background: #4ca392;
        }

        form:last-child button {
            background: #ef4444;
        }

        form:last-child button:hover {
            background: #dc2626;
        }
    </style>
@endpush

@section('content')
<div class="card">
    <h2>Profil Saya</h2>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ auth()->user()->name }}">
        <input type="email" name="email" value="{{ auth()->user()->email }}" disabled>
        <input type="text" name="no_hp" value="{{ auth()->user()->no_hp }}">
        <input type="text" name="alamat" value="{{ auth()->user()->alamat }}">
        <input type="password" name="password" placeholder="Password baru (opsional)">

        <button type="submit">Update Profil</button>
    </form>

    <form action="{{ route('logout') }}" method="POST" style="margin-top:15px">
        @csrf
        <button class="btn btn-teal-outline">Logout</button>
    </form>

    <!-- TAMBAHAN HAPUS AKUN -->
    <form action="{{ route('profile.delete') }}" method="POST" style="margin-top:15px"
        onsubmit="return confirm('Yakin ingin menghapus akun? Data tidak bisa dikembalikan!')">
        @csrf
        @method('DELETE')
        <button>Hapus Akun</button>
    </form>

</div>
@endsection