<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satuan = ['pak','item','lusin','kardus','karung'];
        $kategori = ['racun rumput','racun pohon','racun kembang','vitamin rumput','vitamin pohon','vitamin kembang'];
        $harga = [10000,20000,30000,40000,50000];
        
        foreach ($satuan as $key_satuan => $data_satuan) {
            DB::table('satuans')->insert([
                'satuan' => $data_satuan
            ]);
        }
        foreach ($kategori as $key_kategori => $data_kategori) {
            
            $id_kategori = DB::table('kategoris')->insertGetId([
                'kategori' => $data_kategori
            ]);

            for ($i=0; $i < 20; $i++) { 
                DB::table('produks')->insert([
                    'nama' => Str::random(30),
                    'harga' => $harga[rand(0,4)],
                    'stok' => rand(1,10),
                    'kategori_id' => $id_kategori,
                    'satuan_id' => rand(1,5),
                ]);
            }
        }
    }
}
