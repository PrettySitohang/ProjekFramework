<div class="sidebar">
    <h4><i class="bi bi-fan me-2"></i> AgroGISTech </h4>
    <ul>
        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li>
            <a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Manajemen Pengguna
            </a>
        </li>
        <li><a href="{{ route('artikel.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Manajemen Artikel</a></li>
        <li><a href="{{ route('categoriestag.index') }}" class="{{ request()->routeIs('admin.categoriestag.*') ? 'active' : '' }}"><i class="bi bi-tags"></i> Kategori & Tag</a></li>
        <li><a href="{{ route('admin.comments') }}" class="{{ request()->routeIs('admin.comments') ? 'active' : '' }}"><i class="bi bi-chat-dots"></i> Komentar</a></li>
        {{-- <li><a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan Situs</a></li> --}}
        <li><a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Laporan & Log</a></li>
    </ul>

    <form method="POST" action="{{ route('admin.logout') }}" class="d-grid gap-2 mt-5" style="padding: 0 25px;">
        @csrf
        <button type="submit" class="btn btn-outline-light btn-sm fw-bold">
             <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</div>
