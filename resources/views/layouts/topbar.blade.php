<div class="topbar">
    <h5>Panel Administrasi</h5>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="logout-button">
            <i class="bi bi-person-circle me-1"></i> {{ session('admin_username') ?? 'Guest' }} (Admin)
        </button>
    </form>
</div>
