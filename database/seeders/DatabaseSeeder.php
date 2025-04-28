<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([
        //     StudentSeeder::class
        // ]);
        \App\Models\Admin::create([
            'name' => 'Shafiul Bashar Sumon',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'password_text' => '12345678',
            'user_type' => 1,
            'phone' => '01757967432',
        ]);
    }
}
