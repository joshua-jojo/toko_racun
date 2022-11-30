<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Pengeluaran;
use App\Models\Toko;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satuan = ['pak', 'item', 'lusin', 'kardus', 'karung'];
        $kategori = ['racun rumput', 'racun pohon', 'racun kembang', 'vitamin rumput', 'vitamin pohon', 'vitamin kembang'];
        $harga = [10000, 20000, 30000, 40000, 50000];

        foreach ($satuan as $key_satuan => $data_satuan) {
            DB::table('satuans')->insert([
                'satuan' => $data_satuan
            ]);
        }
        foreach ($kategori as $key_kategori => $data_kategori) {

            $id_kategori = DB::table('kategoris')->insertGetId([
                'kategori' => $data_kategori
            ]);
            $rand = rand(1, 4);
            for ($i = 0; $i < 20; $i++) {
                DB::table('produks')->insert([
                    'nama' => Str::random(30),
                    'harga_jual' => $harga[$rand],
                    'harga_beli' => $harga[$rand - 1],
                    'stok' => rand(1, 10),
                    'kategori_id' => $id_kategori,
                    'satuan_id' => rand(1, 5),
                ]);
            }
        }

        // toko 
        Toko::create([
            'nama' => 'nama toko',
            'alamat' => 'alamat toko',
            'telp' => 'telp toko',
            'keterangan' => 'keterangan toko',
        ]);

        // member 
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'nama' => $faker->name,
                'alamat' => $faker->address,
                'telp' => $faker->phoneNumber,
            ];
            Member::create($data);
        }

        // transaksi
        $jenis_pembayaran = ['cash', 'bri', 'mandiri', 'dana', 'ovo', 'gopay', 'shopeepay'];
        for ($i = 0; $i < 10000; $i++) {
            $grand_total = (rand(1, 200) * 10000);
            $bayar = rand(1, 200) * 10000;
            $kembalian = $bayar - $grand_total;
            $status = $bayar - $grand_total < 0 ? "belum lunas" : "lunas";
            $rand_day = rand(-360, 360);
            $created_at = date('Y-m-d', strtotime(date("Y-m-d") . ($rand_day < 0 ? "-" . $rand_day : "+" . $rand_day) . " days"));
            $id = Transaksi::create([
                'kode_transaksi' => $i,
                'jumlah' => 0,
                'total' => 0,
                'diskon' => 0,
                'ppn' => 0,
                'ppn_total' => 0,
                'grand_total' => $grand_total,
                'jenis_pembayaran' => $jenis_pembayaran[rand(0, 6)],
                'kembalian' => $kembalian,
                'bayar' => $bayar,
                'member_id' => 0,
                'nama_member' => Member::find(rand(1, 100))->nama,
                'status' => $status,
                'created_at' => $created_at,
            ])->id;
        }

        // pengeluaran 
        for ($i = 0; $i < 100; $i++) {
            Pengeluaran::create([
                'tanggal' => date("Y-m-d"),
                'keterangan' => Str::random(10),
                'nominal' => (rand(1, 10) * 10000),
            ]);
        }
    }
}
