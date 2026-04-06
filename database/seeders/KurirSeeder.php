<?php

namespace Database\Seeders;

use App\Models\Kurir;
use Illuminate\Database\Seeder;

class KurirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kurirs = [
            [
                'nama_kurir' => 'Budi Santoso',
                'telpon_kurir' => '08123456789',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
                'status' => 'Aktif'
            ],
            [
                'nama_kurir' => 'Ahmad Ramdhan',
                'telpon_kurir' => '08234567890',
                'alamat' => 'Jl. Sudirman No. 20, Jakarta',
                'status' => 'Aktif'
            ],
            [
                'nama_kurir' => 'Siti Nurhaliza',
                'telpon_kurir' => '08345678901',
                'alamat' => 'Jl. Gatot Subroto No. 30, Jakarta',
                'status' => 'Aktif'
            ],
            [
                'nama_kurir' => 'Riyadi',
                'telpon_kurir' => '08456789012',
                'alamat' => 'Jl. Thamrin No. 40, Jakarta',
                'status' => 'Aktif'
            ],
        ];

        foreach ($kurirs as $kurir) {
            Kurir::create($kurir);
        }
    }
}
