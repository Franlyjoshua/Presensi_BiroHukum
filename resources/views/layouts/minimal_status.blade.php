<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Presensi Kemendiktisaintek'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e9ecef; /* Warna latar yang sedikit berbeda untuk menandakan halaman status */
            display: flex;
            align-items: center; /* Pusatkan konten secara vertikal */
            justify-content: center; /* Pusatkan konten secara horizontal */
            min-height: 100vh;
            color: #333;
            margin: 0; /* Hilangkan margin default body */
            padding: 1rem; /* Beri sedikit padding agar kartu tidak menempel di tepi layar kecil */
        }
    </style>
    @stack('css')
</head>
<body class="antialiased">
    @yield('content')
    {{-- Tidak ada navbar, tidak ada footer --}}
    @stack('js')
</body>
</html>