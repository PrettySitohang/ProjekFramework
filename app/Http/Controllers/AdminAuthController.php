<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

// --- Simulating a Database/User Repository ---
class UserRepository
{
    // Mengubah users menjadi non-static agar bisa diubah (meskipun ini tidak ideal untuk PHP, ini untuk simulasi)
    private static $users = [
        ['username' => 'pretty', 'password' => 'Admin1', 'name' => 'Pretty', 'role' => 'admin'],
        ['username' => 'mei', 'password' => 'Admin2', 'name' => 'Mei', 'role' => 'writer'],
    ];

    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if ($user['username'] === strtolower($username)) {
                return $user;
            }
        }
        return null;
    }

    // Method untuk menambahkan user baru ke simulasi database
    public static function addUser($data)
    {
        // Simulasi pemeriksaan duplikasi username di PHP
        if (self::findByUsername($data['username'])) {
            return false; // User sudah ada
        }

        // Simpan data (menambahkan ke array statis)
        self::$users[] = [
            'username' => strtolower($data['username']),
            'password' => $data['password'],
            'name' => $data['name'],
        ];
        return true;
    }
}
// ---------------------------------------------

class AdminAuthController extends Controller
{
    // === LOGIN METHODS ===

    public function showLoginForm()
    {
        return view('admin.login-admin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = UserRepository::findByUsername($credentials['username']);

        // Verifikasi kredensial (membandingkan password non-hash)
        if ($user && $credentials['password'] === $user['password']) {
            session(['is_admin_logged_in' => true]);
            session(['admin_username' => $user['name']]);
            $request->session()->flash('success', 'Selamat datang kembali, ' . $user['name'] . '!');
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'Username atau password salah')->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['is_admin_logged_in', 'admin_username']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // === REGISTRATION METHODS ===

    public function showRegistrationForm()
    {
        return view('register-admin');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input Ketat
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'alamat' => 'required|string|max:300',
            'tanggal_lahir' => 'required|date',
            'username' => ['required', 'string', 'min:4', 'max:255'], // Hapus 'unique:admin_users'
            'password' => [
                'required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/',
            ],
            'confirm_password' => 'required|same:password',
        ], [
            'name.regex' => 'Nama tidak boleh mengandung angka atau simbol.',
            'alamat.max' => 'Alamat maksimal 300 karakter.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf kapital dan satu angka.',
            'confirm_password.same' => 'Confirm Password tidak sesuai.',
        ]);

        // 2. SIMULASI OTENTIKASI: Tambahkan data ke UserRepository
        $isAdded = UserRepository::addUser($request->only('username', 'password', 'name'));

        if (!$isAdded) {
            // Jika username sudah ada (dicek di UserRepository)
            return back()->withErrors(['username' => 'Username ini sudah digunakan.'])->withInput();
        }

        // 3. Registrasi Berhasil
        return redirect()->route('admin.login')->with('success', 'Registrasi berhasil! Silakan login menggunakan kredensial Anda.');
    }

    // === DEBUGGING METHOD (Digunakan di routes Anda) ===
    public function checkSession()
    {
        $isLoggedIn = session('is_admin_logged_in');
        $username = session('admin_username');

        if ($isLoggedIn) {
            return "Admin **{$username}** sedang login. Status: $isLoggedIn";
        } else {
            return "Admin tidak sedang login.";
        }
    }
}
