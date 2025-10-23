<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Teknologi Sawit</title>

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

        /* --- START: CSS UNTUK KOTAK KOTAK STATISTIK --- */
        .card-stat {
            border-radius: 10px;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 20px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            overflow: hidden;
            position: relative;
        }

        .card-stat:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .card-stat h5 {
            font-weight: 600;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }

        .card-stat p {
            color: white;
            font-weight: 900;
            font-size: 2.5rem;
            margin-top: 0;
            margin-bottom: 0;
        }

        .card-orange {
            background: linear-gradient(45deg, var(--primary-orange), #ff8c00);
        }

        .card-yellow {
            background: linear-gradient(45deg, #ffc107, #ffab00);
        }

        .card-green {
            background: linear-gradient(45deg, #28a745, #15a05b);
        }

        .notification-list, .activity-list {
            list-style: none;
            padding-left: 0;
            margin-top: 1rem;
        }
        .notification-list li, .activity-list li {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            background-color: white;
            margin-bottom: 5px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        /* --- END: CSS UNTUK KOTAK KOTAK STATISTIK --- */
    </style>
    @stack('styles')
</head>

<body>
    <div class="sidebar">
        <h4><i class="bi bi-fan me-2"></i> HaiSawit Admin</h4>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="bi bi-people"></i> Manajemen Pengguna</a></li>
            <li><a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Manajemen Artikel</a></li>
            <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="bi bi-tags"></i> Kategori & Tag</a></li>
            <li><a href="{{ route('admin.comments') }}" class="{{ request()->routeIs('admin.comments') ? 'active' : '' }}"><i class="bi bi-chat-dots"></i> Komentar</a></li>
            <li><a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan Situs</a></li>
            <li><a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Laporan & Log</a></li>
        </ul>

        <form method="POST" action="{{ route('admin.logout') }}" class="d-grid gap-2 mt-5" style="padding: 0 25px;">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm fw-bold">
                 <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h5>Panel Administrasi</h5>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                {{-- PERBAIKAN DI SINI: Mengganti teks 'Pretti' dengan session('admin_username') --}}
                <button type="submit" class="logout-button">
                    <i class="bi bi-person-circle me-1"></i> {{ session('admin_username') ?? 'Guest' }} (Admin)
                </button>
            </form>
        </div>

        <div class="dashboard-body">
            @yield('content')
        </div>

        <div class="footer-admin">
            &copy; {{ date('Y') }} Teknologi Sawit. Hak Cipta Dilindungi.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
