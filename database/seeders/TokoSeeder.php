<?php

namespace Database\Seeders;

use App\Models\Toko;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Toko::create([
            'nama' => 'nama toko',
            'alamat' => 'alamat toko',
            'telp' => 'telp toko',
            'keterangan' => 'keterangan toko',
        ]);
    }
}
