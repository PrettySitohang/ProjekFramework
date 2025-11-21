
@extends('layouts.app')

@section('content')

    <h2 class="mt-2">✏️ Edit Pengguna: {{ $user->name }}</h2>
    <p class="text-muted">Ubah detail akun pengguna di bawah ini.</p>
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

            {{-- FORMULIR EDIT PENGGUNA --}}
            {{-- Action mengarah ke route 'pengguna.update', menggunakan @method('PUT') --}}
            <form action="{{ route('pengguna.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Field Nama --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    {{-- Menampilkan data lama pengguna atau input sebelumnya jika validasi gagal --}}
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

                {{-- Field Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Password (Opsional) --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password Baru (Kosongkan jika tidak diubah)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Konfirmasi Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    <div class="form-text">Jika Anda mengisi password baru, konfirmasi juga harus diisi.</div>
                </div>


                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="bi bi-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection
