@extends('app')

@push('styles')
    <style>
        .card {
            width: 500px;
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

        p {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
            color: #374151;
        }

        a {
            color: #5fb3a2;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
<div class="card">
    <h2>Register</h2>

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="no_hp" placeholder="No HP">
        <input type="text" name="alamat" placeholder="Alamat">

        <button type="submit">Register</button>
    </form>

    <p>
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </p>
</div>
@endsection