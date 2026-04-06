<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'no_hp' => '081234567890',
            'password' => Hash::make('12345678'),
            'jabatan' => 'admin',
        ]);

        User::create([
            'name' => 'Apoteker',
            'email' => 'apoteker@gmail.com',
            'no_hp' => '081234567891',
            'password' => Hash::make('12345678'),
            'jabatan' => 'apoteker',
        ]);

        User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@gmail.com',
            'no_hp' => '081234567892',
            'password' => Hash::make('12345678'),
            'jabatan' => 'karyawan',
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@gmail.com',
            'no_hp' => '081234567893',
            'password' => Hash::make('12345678'),
            'jabatan' => 'kasir',
        ]);

        User::create([
            'name' => 'Pemilik',
            'email' => 'owner@gmail.com',
            'no_hp' => '081234567894',
            'password' => Hash::make('12345678'),
            'jabatan' => 'pemilik',
        ]);


        User::create([
            'name' => 'Kurir',
            'email' => 'kurir@gmail.com',
            'no_hp' => '081234567895',
            'password' => Hash::make('12345678'),
            'jabatan' => 'kurir',
        ]);

        $this->call([
            MetodeBayarSeeder::class,
        ]);
    }

}
