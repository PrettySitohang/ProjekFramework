<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Kredensial Admin yang Ditetapkan
        $adminEmail = 'admin@AgroGISTech.com';

        if (User::where('email', $adminEmail)->exists()) {
            return;
        }

        User::create([
            'name'      => 'Pretti Meysari Br.Sitohang',
            'email'     => $adminEmail,
            'password'  => Hash::make('AdminRahasia123'),
            'role'      => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
