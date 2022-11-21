<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'nama' => Str::random(10),
                'alamat' => Str::random(10),
                'telp' => Str::random(10),
                'diskon' => rand(1, 100),
            ];
            Member::create($data);
        }
    }
}
