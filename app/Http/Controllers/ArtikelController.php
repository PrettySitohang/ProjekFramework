<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; 
class ArtikelController extends Controller
{
    /**
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Admin bisa melihat SEMUA artikel.
        // Menggunakan with(['writer', 'editor']) untuk memuat relasi FK.
        $articles = Article::with(['writer', 'editor'])
                           ->orderBy('article_id', 'desc')
                           ->paginate(12);
        return view('admin.articles.indeks', compact('articles'));
    }

    /**
     * Tampilkan Form Tambah Artikel (CRUD Create).
     * Admin memiliki hak untuk membuat artikel.
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('admin.articles.create');
    }

    /**
     * Simpan Data Artikel Baru (CRUD Create).
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Artikel
        $validatedData = $request->validate([
            'title'             => 'required|string|max:255',
            'content'           => 'required|string',
            'thumbnail_path'    => 'nullable|string|max:255', // Asumsi path/URL, bukan file upload
            // Admin bisa mengatur status awal, atau biarkan default 'draft'
            'status'            => ['required', Rule::in(['draft', 'pending', 'published', 'archived'])],
            // Jika Anda mengizinkan upload file: 'thumbnail_file' => 'nullable|image|max:2048'
        ]);

        // 2. Buat Slug Otomatis (Wajib Unik)
        $slug = Str::slug($validatedData['title']);
        $uniqueSlug = $slug;
        $count = 1;
        while (Article::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $count++;
        }

        // 3. Simpan Data Baru
        Article::create([
            'writer_id'      => Auth::user()->id, // Admin adalah penulis awal
            'title'          => $validatedData['title'],
            'slug'           => $uniqueSlug,
            'content'        => $validatedData['content'],
            'thumbnail_path' => $validatedData['thumbnail_path'],
            'status'         => $validatedData['status'],
            'published_at'   => ($validatedData['status'] === 'published') ? now() : null,
        ]);

        return redirect()->route('admin.articles.indeks')
                         ->with('success', 'Artikel baru berhasil ditambahkan!');
    }


    /**
     * Tampilkan Form Edit Artikel (CRUD Update).
     * @param \App\Models\Article $article (Route Model Binding)
     * @return \Illuminate\View\View
     */
    public function edit(Article $article)
    {
        // Hanya perlu otorisasi di Policy, tetapi Admin selalu diizinkan
        // $this->authorize('update', $article);

        return view('admin.articles.edit', compact('articles'));
    }

    /**
     * Perbarui Data Artikel (CRUD Update).
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article (Route Model Binding)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Article $article)
    {
        // Admin bisa mengedit, termasuk mengubah penulis (jika diperlukan)
        $validatedData = $request->validate([
            'title'          => 'required|string|max:255',
            // Pastikan slug unik, KECUALI slug itu milik artikel yang sedang diupdate
            'slug'           => ['required', 'string', 'max:255', Rule::unique('articles')->ignore($article->article_id, 'article_id')],
            'content'        => 'required|string',
            'thumbnail_path' => 'nullable|string|max:255',
            'status'         => ['required', Rule::in(['draft', 'pending', 'published', 'archived'])],
            'writer_id'      => 'required|exists:users,id', // Admin bisa ganti penulis
        ]);

        // Atur published_at jika status diubah menjadi published
        if ($article->status !== 'published' && $validatedData['status'] === 'published') {
            $validatedData['published_at'] = now();
        } elseif ($validatedData['status'] !== 'published') {
            $validatedData['published_at'] = null; // Hapus tanggal publish jika status berubah
        }

        $article->update($validatedData);

        // TODO: Jika diperlukan, tambahkan logic INSERT ke article_revisions di sini
        // (Jika Admin ingin mencatat log seperti Editor)

        return redirect()->route('articles.index')
                         ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Hapus Artikel (CRUD Delete).
     * @param \App\Models\Article $article (Route Model Binding)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        // Admin memiliki hak penuh untuk menghapus artikel
        // Relasi onDelete('cascade') akan otomatis menghapus entri di pivot dan revisions.
        $article->delete();

        return redirect()->route('articles.index')
                         ->with('success', 'Artikel berhasil dihapus!');
    }
}
