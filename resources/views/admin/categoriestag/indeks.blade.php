@extends('layouts.app')

@section('content')

    <h2 class="mt-2">Manajemen Kategori & Tag</h2>
    <p class="text-muted">Kelola semua kategori dan tag yang digunakan untuk mengelompokkan artikel.</p>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ============================================================================== --}}
    {{-- BAGIAN MANAJEMEN KATEGORI --}}
    {{-- ============================================================================== --}}

    <div class="card shadow mb-5">
        {{-- TEMA KATEGORI: Mengganti bg-primary dengan warna yang lebih gelap (seperti di header dashboard) --}}
        <div class="card-header text-white" style="background-color: #ffc107;">
            <h4 class="mb-0">Daftar Kategori 🏷️</h4>
        </div>
        <div class="card-body">
            {{-- Tombol Tambah Kategori (CREATE) --}}
            <div class="d-flex justify-content-end mb-3">
                {{-- Mengganti btn-success dengan warna Oranye terang (seperti di card dashboard) --}}
                <a href="{{ route('categoriestag.create', ['type' => 'category']) }}" class="btn text-white" style="background-color: #28a745; border-color: #28a745;">
                    <i class="bi bi-plus-circle-fill me-2"></i> Tambah Kategori Baru
                </a>
            </div>

            {{-- Tabel Kategori (READ) --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Artikel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menggunakan variabel $categories --}}
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td><span class="badge bg-secondary">{{ $category->slug }}</span></td>
                                <td>{{ Str::limit($category->description ?? '-', 50) }}</td>
                                <td>{{ $category->articles_count ?? 0 }}</td>
                                <td>
                                    {{-- Tombol Edit (UPDATE): Mengganti btn-primary dengan warna Biru Tua --}}
                                    <a href="{{ route('categoriestag.edit', ['id' => $category->id, 'type' => 'category']) }}" class="btn btn-sm text-white me-2" style="background-color: #313d50; border-color: #313d50;"><i class="bi bi-pencil-square"></i> Edit</a>

                                    {{-- Tombol Hapus (DELETE) --}}
                                    <form action="{{ route('categoriestag.destroy', ['id' => $category->id, 'type' => 'category']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus Kategori \'{{ $category->name }}\'? Relasi artikel akan otomatis terputus.')"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data kategori yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi Kategori --}}
            <div class="mt-3">
                {{-- Menggunakan parameter 'cat_page' untuk paginasi kategori --}}
                {{ $categories->appends(request()->except('cat_page'))->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    ---

    {{-- ============================================================================== --}}
    {{-- BAGIAN MANAJEMEN TAG --}}
    {{-- ============================================================================== --}}

    <div class="card shadow">
        {{-- TEMA TAG: Menggunakan warna Oranye terang (seperti card 'Jumlah Artikel') --}}
        <div class="card-header text-white" style="background-color: #ff6600;">
            <h4 class="mb-0">Daftar Tag 🏷️</h4>
        </div>
        <div class="card-body">
            {{-- Tombol Tambah Tag (CREATE) --}}
            <div class="d-flex justify-content-end mb-3">
                {{-- Mengganti btn-success dengan warna Biru Tua (atau Orange jika ingin kontras) --}}
                <a href="{{ route('categoriestag.create', ['type' => 'tag']) }}" class="btn text-white" style="background-color: #28a745; border-color: #28a745;">
                    <i class="bi bi-plus-circle-fill me-2"></i> Tambah Tag Baru
                </a>
            </div>

            {{-- Tabel Tag (READ) --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tag</th>
                            <th>Slug</th>
                            <th>Jumlah Artikel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menggunakan variabel $tags --}}
                        @forelse ($tags as $tag)
                            <tr>
                                <td>{{ ($tags->currentPage() - 1) * $tags->perPage() + $loop->iteration }}</td>
                                <td>{{ $tag->name }}</td>
                                <td><span class="badge bg-secondary">{{ $tag->slug }}</span></td>
                                <td>{{ $tag->articles_count ?? 0 }}</td>
                                <td>
                                    {{-- Tombol Edit (UPDATE): Mengganti btn-primary dengan warna Biru Tua --}}
                                    <a href="{{ route('categoriestag.edit', ['id' => $tag->id, 'type' => 'tag']) }}" class="btn btn-sm text-white me-2" style="background-color: #313d50; border-color: #313d50;"><i class="bi bi-pencil-square"></i> Edit</a>

                                    {{-- Tombol Hapus (DELETE) --}}
                                    <form action="{{ route('categoriestag.destroy', ['id' => $tag->id, 'type' => 'tag']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus Tag \'{{ $tag->name }}\'? Relasi artikel akan otomatis terputus.')"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data tag yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi Tag --}}
            <div class="mt-3">
                 {{-- Menggunakan parameter 'tag_page' untuk paginasi tag --}}
                {{ $tags->appends(request()->except('tag_page'))->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
