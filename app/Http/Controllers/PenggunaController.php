<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Types\Relations\Role;
use Illuminate\Validation\Rule; // Diperlukan untuk validasi saat Update

class PenggunaController extends Controller
{
    // READ (Daftar Pengguna)
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.pengguna.indeks', compact('users')); // 'indeks' adalah view tabel Anda
    }

    // CREATE (Tampilkan Form Tambah)
    public function create()
    {
        return view('admin.pengguna.tbhData'); // 'tbhData' adalah view form tambah
    }

    // CREATE (Simpan Data Baru)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => ['required', Rule::in(['admin', 'editor', 'writer'])],
        ]);

        User::create([
            'name'     => $validatedData['name'],
            'email'    => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role'=> $validatedData['role'],
        ]);

        return redirect()->route('pengguna.index')
                         ->with('success', 'Pengguna baru berhasil ditambahkan!');
    }


    public function edit(User $user) // Menggunakan Route Model Binding
    {
        return view('admin.pengguna.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            // Rule::unique: Pastikan email unik, KECUALI email itu milik pengguna saat ini ($user->id)
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // Password baru opsional. Hanya divalidasi jika diisi.
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => ['required', Rule::in(['admin', 'editor', 'writer'])],
        ]);

        // 2. Persiapkan Data Update
        $updateData = [
            'name'  => $validatedData['name'],
            'email' => $validatedData['email'],
            'role'=> $validatedData['role'],
        ];

        // Jika password diisi, enkripsi dan tambahkan ke data update
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }
        $user->update($updateData);

        return redirect()->route('pengguna.index')
                         ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        // Hapus pengguna
        $user->delete();

        return redirect()->route('pengguna.index')
                         ->with('success', 'Pengguna berhasil dihapus!');
    }
}
