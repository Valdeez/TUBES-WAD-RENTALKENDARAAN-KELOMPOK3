<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
        }

        .card {
            width: 350px;
            margin: 110px auto;
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

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: #dc2626;
            text-align: center;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Login</h2>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p>
        Belum punya akun? <a href="{{ route('register') }}">Register</a>
    </p>
</div>

</body>
</html>
