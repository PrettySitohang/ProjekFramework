@extends('layouts.app')

@section('content')

    <h2 class="mt-2">Manajemen Pengguna</h2>
    <p class="text-muted">Kelola semua akun pengguna terdaftar pada platform.</p>
    <hr>

    {{-- Tombol Tambah Pengguna (Opsional) --}}
    <div class="d-flex justify-content-end mb-3">
        {{-- Diubah: Menggunakan style inline untuk warna background kustom #25d366 --}}
        {{-- Kita juga akan menautkannya ke rute 'tbhData' --}}
        <a href="{{ route('users.tbhData') }}" class="btn text-white"
           style="background-color: #25d366; border-color: #25d366;">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Pengguna Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">Daftar Pengguna</h5>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Terdaftar Sejak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-sm btn-info text-white me-2"><i class="bi bi-pencil-square"></i> Edit</a>
                                    <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data pengguna yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            <div class="mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
