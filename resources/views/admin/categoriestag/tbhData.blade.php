@extends('layouts.app')

@section('content')

    {{-- Penentuan Judul berdasarkan tipe --}}
    @php
        $isCategory = ($type === 'category');
        $title = $isCategory ? 'Kategori Baru' : 'Tag Baru';
        $itemLabel = $isCategory ? 'Kategori' : 'Tag';
    @endphp

    <h2 class="mt-2">Tambah {{ $itemLabel }}</h2>
    <p class="text-muted">Isi formulir di bawah ini untuk menambahkan {{ $itemLabel }} baru ke database.</p>
    <hr>

    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">Form Tambah {{ $title }}</h5>

            {{-- Form akan menargetkan rute store dengan menyertakan parameter type --}}
            <form action="{{ route('categoriestag.store', ['type' => $type]) }}" method="POST">
                @csrf

                {{-- Field Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama {{ $itemLabel }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Slug --}}
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug (URL Friendly) <small class="text-muted">(Akan diisi otomatis jika dikosongkan)</small></label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Description (Hanya muncul jika tipenya adalah Kategori) --}}
                @if ($isCategory)
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Kategori</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <a href="{{ route('categoriestag.index', ['type' => $type]) }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-save me-2"></i> Simpan {{ $itemLabel }}</button>
            </form>
        </div>
    </div>
@endsection
