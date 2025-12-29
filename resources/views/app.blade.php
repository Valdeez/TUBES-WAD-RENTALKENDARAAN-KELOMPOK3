<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Vehicle 3!</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar { padding: 20px 0; background-color: #ffffff; }
        .navbar-brand { font-weight: 600; font-size: 1.5rem; color: #333; }
        .nav-link { color: #333; font-weight: 400; margin: 0 15px; }
        .nav-link:hover { color: #5da898; }
        .active { color: #5da898 !important; }
        .btn-teal-outline { color: #5da898; border: 1.5px solid #5da898; padding: 8px 25px; border-radius: 5px; text-decoration: none; }
        .btn-teal-outline:hover { background-color: #5da898; color: white; }
        .btn-teal-fill { background-color: #5da898; color: white; border: none; padding: 8px 25px; border-radius: 5px; text-decoration: none; }
        .btn-teal-fill:hover { background-color: #4c8c7f; color: white; }
    </style>

    @stack('styles')
</head>
<body>

    @include('navbar')

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>