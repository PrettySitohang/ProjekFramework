<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryTagController extends Controller
{
    // Tentukan Model yang akan digunakan berdasarkan tipe (category atau tag)
    private function getModel(string $type)
    {
        return $type === 'category' ? Category::class : Tag::class;
    }

    // Tentukan nama Primary Key (PK) karena keduanya berbeda
    private function getPrimaryKey(string $type)
    {
        // Karena di kedua model PKnya adalah 'id', fungsi ini bisa disederhanakan
        return 'category_id';
    }

    /**
     * Index - Menampilkan daftar Kategori dan Tag dalam satu halaman (READ).
     * PENYESUAIAN: Mengambil data Categories dan Tags secara terpisah
     */
    public function index() // Hapus $request dari parameter jika tidak diperlukan
    {
        // Mengambil data Kategori dengan paginasi
        // Asumsi model memiliki relasi 'articles' dengan withCount
        $categories = Category::withCount('articles')->orderBy('name', 'asc')->paginate(10, ['*'], 'cat_page');

        // Mengambil data Tag dengan paginasi
        $tags = Tag::withCount('articles')->orderBy('name', 'asc')->paginate(10, ['*'], 'tag_page');

        // Kirimkan kedua variabel ke view
        return view('admin.categoriestag.indeks', compact('categories', 'tags'));
    }

    // =========================================================================
    // Metode CREATE, STORE, EDIT, UPDATE, dan DESTROY di bawah tetap dapat
    // menggunakan logika $type yang Anda buat, karena mereka hanya menangani
    // satu tipe data pada satu waktu (melalui form/tombol yang menargetkan tipe tertentu).
    // =========================================================================


    /**
     * Tampilkan Form Tambah Data (CRUD Create).
     */
    public function create(Request $request)
    {
        // Logika tetap dipertahankan
        $type = $request->get('type', 'category');
        return view('admin.categoriestag.tbhData', compact('type'));
    }

    /**
     * Simpan Data Baru (CRUD Create).
     */
    public function store(Request $request)
    {
        $type = $request->get('type');
        $Model = $this->getModel($type);

        // 1. Validasi Data
        // PENTING: Untuk Rule::unique, pastikan model memiliki getTableName()
        // atau gunakan nama tabel secara langsung: Rule::unique('categories') atau Rule::unique('tags')
        $tableName = $type === 'category' ? 'categories' : 'tags';

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique($tableName)],
            'description' => $type === 'category' ? 'nullable|string' : 'forbidden',
        ]);

        // 2. Jika slug kosong atau tidak diset, buat dari name
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        $Model::create($validatedData);

        return redirect()->route('categoriestag.index', ['type' => $type])
                            ->with('success', ucfirst($type) . ' berhasil ditambahkan!');
    }


    /**
     * Tampilkan Form Edit Data (CRUD Update).
     */
    public function edit(Request $request, int $id)
    {
        $type = $request->get('type');
        $Model = $this->getModel($type);
        $pk = $this->getPrimaryKey($type);

        $item = $Model::where($pk, $id)->firstOrFail();

        return view('admin.categoriestag.edit', compact('item', 'type'));
    }

    /**
     * Perbarui Data (CRUD Update).
     */
    public function update(Request $request, int $id)
    {
        $type = $request->get('type');
        $Model = $this->getModel($type);
        $pk = $this->getPrimaryKey($type);

        $item = $Model::where($pk, $id)->firstOrFail();

        $tableName = $type === 'category' ? 'categories' : 'tags';

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Slug harus unik, KECUALI slug itu milik item saat ini
            'slug' => ['required', 'string', 'max:255', Rule::unique($tableName)->ignore($id, $pk)],
            'description' => $type === 'category' ? 'nullable|string' : 'forbidden',
        ]);

        // Jika slug kosong atau tidak diset, buat dari name
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        $item->update($validatedData);

        return redirect()->route('categoriestag.index', ['type' => $type])
                            ->with('success', ucfirst($type) . ' berhasil diperbarui!');
    }

    /**
     * Hapus Data (CRUD Delete).
     */
    public function destroy(Request $request, int $id)
    {
        $type = $request->get('type');
        $Model = $this->getModel($type);
        $pk = $this->getPrimaryKey($type);

        $Model::where($pk, $id)->delete();

        return redirect()->route('categoriestag.index', ['type' => $type])
                            ->with('success', ucfirst($type) . ' berhasil dihapus!');
    }
}
