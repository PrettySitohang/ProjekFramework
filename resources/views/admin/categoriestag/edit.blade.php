<?php
// Variabel yang diharapkan dari Controller: $item (data Kategori/Tag), $type ('category' atau 'tag')
?>
@extends('layouts.app')

@section('title', 'Edit ' . ucfirst($type) . ': ' . $item->name)

@section('content')
<div class="p-6 bg-white rounded-lg shadow-xl max-w-2xl mx-auto">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-3">
        Edit {{ ucfirst($type) }} "{{ $item->name }}"
    </h1>

    {{-- Route Model Binding di Controller menggunakan ID, jadi kita tambahkan ID di sini --}}
    <form action="{{ route('categoriestag.update', [$item->{$item->primaryKey}, 'type' => $type]) }}" method="POST">
        @csrf
        @method('PUT') {{-- Wajib menggunakan method PUT untuk operasi update di Laravel --}}

        {{-- Field Nama --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama {{ ucfirst($type) }}</label>
            <input type="text" name="name"  category_idy="name" value="{{ old('name', $item->name) }}" required
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Field Slug --}}
        <div class="mb-4">
            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" name="slug"  category_idy="slug" value="{{ old('slug', $item->slug) }}" required
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500 @error('slug') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Slug harus unik dan digunakan untuk URL.</p>
            @error('slug')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Field Deskripsi (Hanya untuk Kategori) --}}
        @if ($type === 'category')
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description"  category_idy="description" rows="3"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror">{{ old('description', $item->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.categoriestag.index', ['type' => $type]) }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Update {{ ucfirst($type) }}
            </button>
        </div>
    </form>
</div>
@endsection
