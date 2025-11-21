@extends('layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')

<h1 class="text-2xl font-semibold text-gray-900 mb-6">Manajemen Artikel</h1>

{{-- Filter dan Tombol Tambah --}}
<div class="flex justify-between items-center mb-6 border-b pb-4">
    <div class="flex space-x-4">
        {{-- Filter Status Artikel --}}
        <select article_id"statusFilter" class="form-select border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
            <option value="">Semua Status</option>
            <option value="draft">Draft</option>
            <option value="pending">Pending</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
        </select>

        {{-- Filter Peran (Hanya untuk Admin dan Editor) --}}
        @auth
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                <select article_id"authorFilter" class="form-select border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    <option value="">Semua Penulis</option>
                    {{-- ... data penulis ... --}}
                </select>
            @endif
        @endauth
    </div>

    {{-- Tombol Tambah Artikel (Hanya untuk Admin dan Penulis) --}}
    @auth
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'writer')
            <a href="{{ route('writer.articles.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambahkan Artikel
            </a>
        @endif
    @endauth
</div>


{{-- Grid Artikel --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

    @forelse ($articles as $article)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2
            @if($article->status == 'pending') border-blue-500
            @elseif($article->status == 'draft') border-yellow-500
            @elseif($article->status == 'published') border-green-500
            @endif">

            {{-- Gambar Thumbnail --}}
            <img class="h-48 w-full object-cover"
                 src="{{ $article->thumbnail_path ?? asset('images/default_thumb.jpg') }}"
                 alt="{{ $article->title }}">

            <div class="p-4">

                {{-- Badge Status --}}
                <x-article-status :status="$article->status" />

                {{-- Judul Artikel --}}
                <h3 class="mt-2 text-xl font-bold text-gray-900 line-clamp-2" title="{{ $article->title }}">
                    {{ $article->title }}
                </h3>

                {{-- Info Penulis & Tanggal --}}
                <p class="mt-1 text-sm text-gray-500">
                    Oleh: **{{ $article->writer->name ?? 'N/A' }}**
                </p>
                <p class="text-xs text-gray-400">
                    Update: {{ $article->updated_at->format('d M Y') }}
                </p>

                {{-- Aksi Cepat (Tombol) --}}
                <div class="mt-4 flex space-x-2">

                    @auth
                        @php
                            $user = auth()->user();
                        @endphp

                        {{-- Tombol Edit & Klaim --}}
                        {{-- Logika Policy Update (Admin, Editor, Writer Kondisional) --}}
                        @can('update', $article)
                            @php
                                $route = ($user->role == 'writer')
                                    ? route('writer.articles.edit', $article)
                                    : route('admin.articles.edit', $article); // Defaultkan ke admin edit
                            @endphp

                            <a href="{{ $route }}" class="text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded">
                                Edit
                            </a>
                        @elsecan('claim', $article)
                            {{-- Catatan: Policy claim harus ada di ArticlePolicy --}}
                            @if($user->role === 'editor' && $article->status === 'pending')
                                <form method="POST" action="{{ route('editor.claim', $article) }}">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded">
                                        Klaim & Edit
                                    </button>
                                </form>
                            @endif
                        @endcan

                        {{-- Tombol Delete (Admin & Writer Kondisional) --}}
                        @can('delete', $article)
                            <form method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 px-3 py-1 border border-red-300 rounded">
                                    Hapus
                                </button>
                            </form>
                        @endcan

                        {{-- Tombol Ajukan Review (Hanya untuk Penulis pada status 'draft') --}}
                        @if($user->role === 'writer' && $article->status === 'draft' && $article->writer_id === $user->id)
                            <a href="{{ route('writer.articles.submit', $article) }}" class="text-sm font-medium text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded">
                                Ajukan Review
                            </a>
                        @endif

                    @endauth

                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-10 border border-dashed rounded-lg bg-gray-50">
            <p class="text-lg text-gray-500">Belum ada artikel yang tersedia dalam filter ini.</p>
        </div>
    @endforelse

    {{-- Kartu Tambah Artikel --}}
    @auth
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'writer')
            <a href="{{ route('writer.articles.create') }}" class="flex flex-col items-center justify-center p-6 bg-gray-100 border-2 border-dashed border-gray-400 rounded-lg hover:bg-gray-200 transition duration-150 ease-in-out">
                <svg class="h-12 w-12 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span class="mt-4 text-gray-600 font-medium">Tambahkan Artikel</span>
            </a>
        @endif
    @endauth

</div>

@endsection
