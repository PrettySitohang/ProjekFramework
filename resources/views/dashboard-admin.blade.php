@extends('layouts-admin')

{{--
    Catatan:
    1. Kode ini mengasumsikan 'layouts-admin' sudah memuat Bootstrap (atau framework CSS serupa).
    2. Grafik menggunakan pustaka Chart.js yang dimuat melalui CDN.
    3. Variabel $adminUsername (dari AdminDashboardController) akan digunakan di layout utama (jika ada).
    4. Sesi Flash 'success' akan ditampilkan di sini.
--}}

@section('content')

    {{-- Notifikasi Flash Session --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="mt-2">Selamat Datang, <b>Admin!</b></h2>
    <p class="text-muted">Kelola konten dan fungsionalitas Teknologi Sawit** dengan mudah di sini.</p>
    <hr>

    <h4>Ringkasan Situs</h4>
    <div class="row mb-5">
        {{-- Card 1: Jumlah Artikel --}}
        <div class="col-md-4 mb-3">
            <div class="card-stat card-orange p-4 rounded shadow">
                <h5 class="text-white">Jumlah Artikel</h5>
                <p class="text-white display-4 font-weight-bold">{{ $stats['articles'] ?? 0 }}</p>
            </div>
        </div>

        {{-- Card 2: Pengguna Aktif --}}
        <div class="col-md-4 mb-3">
            <div class="card-stat card-yellow p-4 rounded shadow">
                <h5 class="text-white">Pengguna Aktif (Online)</h5>
                <p class="text-white display-4 font-weight-bold">{{ $stats['active_users'] ?? 0 }}</p>
            </div>
        </div>

        {{-- Card 3: Total Trafik --}}
        <div class="col-md-4 mb-3">
            <div class="card-stat card-green p-4 rounded shadow">
                <h5>Total Trafik (Views)</h5>
                <p class="text-white display-4 font-weight-bold">{{ $stats['site_traffic'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- BAGIAN GRAFIK BARU --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card p-4 rounded shadow">
                <h4 class="mb-3">📈 Grafik Penggunaan Website Bulanan</h4>
                {{-- Canvas untuk grafik --}}
                <canvas id="salesChart" style="max-height: 400px;"></canvas>
            </div>
        </div>
    </div>

    {{-- BAGIAN NOTIFIKASI DAN AKTIVITAS --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <h4>🔔 Notifikasi Sistem</h4>
            <div class="bg-white p-3 rounded shadow-sm border">
                @if(count($notifications) > 0)
                    <ul class="notification-list list-unstyled">
                        @foreach($notifications as $note)
                            <li class="p-2 border-bottom"><i class="bi bi-bell-fill me-2 text-warning"></i> {{ $note }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">Tidak ada notifikasi saat ini.</p>
                @endif
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <h4>🔄 Ringkasan Aktivitas Terbaru</h4>
            <div class="bg-white p-3 rounded shadow-sm border">
                @if(count($recentActivities) > 0)
                    <ul class="activity-list list-unstyled">
                        @foreach($recentActivities as $activity)
                            <li class="p-2 border-bottom"><i class="bi bi-check-circle-fill me-2 text-success"></i> {{ $activity }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">Tidak ada aktivitas terbaru.</p>
                @endif
            </div>
        </div>
    </div>

@endsection

{{--
    Bagian CSS untuk Card Kustom
    Biasanya ini diletakkan di file CSS eksternal atau di layout utama
--}}
@push('styles')
<style>
    .card-stat {
        color: white;
        border: none;
        transition: transform 0.3s;
        min-height: 150px;
    }
    .card-stat:hover {
        transform: translateY(-5px);
    }
    .card-orange { background-color: #ff8c00; } /* Warna oranye */
    .card-yellow { background-color: #ffc107; } /* Warna kuning/emas */
    .card-green { background-color: #28a745; } /* Warna hijau */
    .card-stat h5 {
        font-size: 1rem;
        opacity: 0.8;
        margin-bottom: 0.5rem;
    }
    .card-stat p {
        margin-bottom: 0;
        font-size: 3rem;
    }
    .notification-list li, .activity-list li {
        margin-bottom: 5px;
        padding-left: 0;
    }
    .notification-list .bi-bell-fill, .activity-list .bi-check-circle-fill {
        font-size: 1.2rem;
    }
</style>
@endpush

{{--
    Bagian Script untuk Chart.js (Grafik)
    Ini dimuat setelah konten, memastikan elemen Canvas sudah ada.
--}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data fiktif untuk demo grafik
        const salesData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Trafik Views',
                data: [65, 59, 80, 81, 56, 55, 40, 68, 75, 90, 85, 95], // Data fiktif
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 2,
                tension: 0.4, // Membuat garis lebih melengkung (smooth)
                pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                pointRadius: 4
            }]
        };

        const config = {
            type: 'line',
            data: salesData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Penggunaan Website Bulanan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Viewers (Rb)'
                        }
                    }
                }
            },
        };

        // Inisialisasi Chart
        const salesChartContext = document.getElementById('salesChart');
        if (salesChartContext) {
            new Chart(
                salesChartContext,
                config
            );
        }
    });
</script>
@endpush
