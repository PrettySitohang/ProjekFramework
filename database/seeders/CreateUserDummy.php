<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateUserDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 1000) as $index) {
            DB::table('users')->insert([
                'name'              => $faker->name(),
                'role'              => $faker->randomElement(['admin', 'editor', 'writer']),
                'email'             => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password'          => bcrypt('password'), // default password
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
