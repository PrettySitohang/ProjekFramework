<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Teknologi Sawit @yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-orange: #ff6600;
            --secondary-orange: #ff9900;
            --light-bg: #f5f7fa;
            --dark-text: #2c3e50;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Montserrat', sans-serif;
            color: var(--dark-text);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(0deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
            height: 100vh;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            padding-top: 20px;
            box-shadow: 6px 0 20px rgba(0, 0, 0, 0.25);
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar h4 {
            text-align: center;
            font-weight: 900;
            color: white;
            margin-bottom: 2.5rem;
            font-size: 1.6rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            margin: 5px 15px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            padding-left: 30px;
        }

        .sidebar a.active {
            background-color: #fff;
            color: var(--primary-orange);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-weight: 700;
        }
        .sidebar a.active i {
            color: var(--primary-orange);
        }

        /* Main Content */
        .main-content {
            margin-left: 240px;
            padding: 0;
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 9;
            border-bottom: 1px solid #eee;
        }

        .topbar h5 {
            color: var(--dark-text);
            font-weight: 700;
            margin: 0;
            font-size: 1.1rem;
        }

        /* Tombol Logout Topbar */
        .logout-button {
            background-color: transparent;
            color: var(--dark-text);
            border: 1px solid #ccc;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .logout-button:hover {
            background-color: var(--primary-orange);
            color: white;
            border-color: var(--primary-orange);
        }

        .dashboard-body {
            padding: 30px;
            padding-bottom: 80px;
        }

        /* Footer Minimalis */
        .footer-admin {
            margin-left: 240px;
            padding: 15px 30px;
            text-align: center;
            font-size: 0.85rem;
            color: #777;
            background-color: white;
            border-top: 1px solid #eee;
        }

        /* --- START: CSS UNTUK KOTAK KOTAK STATISTIK GUDANG (BARU) --- */
        .card-stat-gudang {
            border-radius: 12px;
            color: white;
            text-align: left;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-stat-gudang:hover {
            transform: translateY(-7px) scale(1.01);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .card-stat-gudang h5 {
            font-weight: 700;
            opacity: 0.95;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .card-stat-gudang p {
            color: white;
            font-weight: 900;
            font-size: 3rem;
            margin-top: 0;
            margin-bottom: 0;
            line-height: 1;
        }

        .card-stat-gudang .icon-bg {
            position: absolute;
            right: -15px;
            bottom: -15px;
            font-size: 6rem;
            color: rgba(255, 255, 255, 0.2);
            z-index: 1;
            transform: rotate(-15deg);
            pointer-events: none;
        }

        /* Warna Gradien Baru */
        .card-gradient-green {
            background: linear-gradient(45deg, #28a745, #218838); /* Hijau */
        }
        .card-gradient-red {
            background: linear-gradient(45deg, #dc3545, #c82333); /* Merah */
        }
        .card-gradient-blue {
            background: linear-gradient(45deg, #007bff, #0056b3); /* Biru */
        }

        /* --- END: CSS UNTUK KOTAK KOTAK STATISTIK GUDANG --- */
    </style>
    @stack('styles')
</head>

<body>
    {{-- Memanggil sidebar.blade.php --}}
    @include('layouts.sidebar')

    <div class="main-content">
        {{-- Memanggil topbar.blade.php --}}
        @include('layouts.topbar')

        <div class="dashboard-body">
            {{-- Konten dari view lain (e.g., admin.dashboard-admin.blade.php) masuk di sini --}}
            @yield('content')
        </div>

        {{-- Memanggil footer.blade.php --}}
        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
