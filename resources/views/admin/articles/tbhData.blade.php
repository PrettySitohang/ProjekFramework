@extends('layouts.app')

@section('content')

    <h2 class="mt-2">Tambah Pengguna Baru</h2>
    <p class="text-muted">Isi detail di bawah ini untuk mendaftarkan akun pengguna baru.</p>
    <hr>

    <div class="card shadow-sm mb-5">
        <div class="card-body p-4">

            {{-- Menampilkan Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORMULIR TAMBAH PENGGUNA --}}
            <form action="{{ route('pengguna.store') }}" method="POST">
                @csrf

                {{-- Field Nama --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id"name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Konfirmasi Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password <span class="text-danger">*</span></label>
                    {{-- Nama field harus 'password_confirmation' agar validasi 'confirmed' di Controller berfungsi --}}
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                    {{-- Ganti input type="enum" menjadi select element --}}
                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>

                        {{-- Opsi untuk setiap nilai ENUM --}}

                        {{-- Opsi 'admin' --}}
                        <option value="admin"
                            {{-- Jika old('role') adalah 'admin', pilih opsi ini. Jika tidak ada old('role'), abaikan ini. --}}
                            {{ old('role') == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        {{-- Opsi 'editor' --}}
                        <option value="editor"
                            {{ old('role') == 'editor' ? 'selected' : '' }}>
                            Editor
                        </option>

                        {{-- Opsi 'writer' (Default) --}}
                        <option value="writer"
                            {{-- Opsi ini dipilih jika:
                                1. old('role') adalah 'writer', ATAU
                                2. Tidak ada old('role') DAN ini adalah default (atau jika old('role') kosong)
                            --}}
                            {{ old('role') == 'writer' || old('role') == null ? 'selected' : '' }}>
                            Writer
                        </option>

                    </select>

                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <button type="submit" class="btn btn-success fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i> Daftarkan Pengguna
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection
