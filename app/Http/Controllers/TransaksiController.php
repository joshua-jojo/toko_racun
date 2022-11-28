<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cari = $request->cari ?: '';
        $show = $request->show ?: 5;
        $range = $request->range ? ['dari' => empty($request->range['dari']) ? date('Y-m-d') : $request->range['dari'], 'sampai' => empty($request->range['sampai']) ? date('Y-m-d') : $request->range['sampai']] : ['dari' => date('Y-m-d'), 'sampai' => date('Y-m-d')];
        // dd($range);
        $transaksi = Transaksi::with(['transaksi_detail'])
            ->selectRaw("*,date_format(created_at,'%Y %M %d %H:%i') as waktu")
            ->whereDate(DB::raw('date(created_at)'), '>=', new DateTime($range['dari']))
            ->whereDate(DB::raw('date(created_at)'), '<=', new DateTime($range['sampai']))
            ->where(DB::raw("date_format(transaksis.created_at,'%Y %M %d %H:%i')"), 'like', '%' . $cari . '%')
            ->orWhere('kode_transaksi', 'like', '%' . $cari . '%')
            ->orWhere('jenis_pembayaran', 'like', '%' . $cari . '%')
            ->orWhere('grand_total', 'like', '%' . $cari . '%')
            ->orWhere('nama_member', 'like', '%' . $cari . '%')
            ->orWhere('status', 'like', '%' . $cari . '%')
            ->latest()
            ->paginate($show)
            ->withQueryString();

        return inertia()->render('transaksi', [
            'transaksi' => $transaksi,
            'cari' => $cari,
            'show' => $show,
            'range' => $range,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $member = $request['data_transkasi']['member'];
        if ($member['id'] != 0) {
            $data_transaksi = Transaksi::latest()->where("nama_member", $member['nama'])->first();
            if ($data_transaksi != null) {
                $final = [
                    'total' => $data_transaksi->total += $request->data_transkasi['total'],
                    'ppn_total' => $data_transaksi->ppn_total += $request->data_transkasi['ppn_total'],
                    'diskon' => $data_transaksi->diskon += $request->data_transkasi['diskon']['final_diskon'],
                    'grand_total' => $data_transaksi->grand_total += $request->data_transkasi['grand_total'],
                    'kembalian' => $data_transaksi->kembalian += $request->data_transkasi['kembalian'],
                    'jenis_pembayaran' => $request->data_transkasi['bayar']['jenis_pembayaran'],
                    'no_transaksi' => $request->data_transkasi['bayar']['no_transaksi']

                ];
                $final['status'] = $final['kembalian'] < 0 ? "belum lunas" : 'lunas';
                $data_transaksi->update($final);
                foreach ($request->data_transkasi['produk'] as $key => $value) {
                    Produk::find($value['id'])->update($value);
                    $value['transaksi_id'] = $data_transaksi->id;
                    $value['created_at'] = date('Y-m-d H:i:s');
                    TransaksiDetail::create($value);
                }
            }
        }
        $master = $request->data_transkasi;
        $master_transaksi = Transaksi::latest();

        foreach ($master['produk'] as $key => $value) {
            Produk::find($value['id'])->update($value);
        }

        $kode_transaksi = 'T' . date('ymd') . '-1';
        if ($master_transaksi->count() > 0) {
            $kode = explode('-', $master_transaksi->latest()->first()->kode_transaksi);
            $kode_transaksi = 'T' . date('ymd') . '-' . ($kode[1] + 1);
        }

        $id = Transaksi::create([
            'kode_transaksi' => $kode_transaksi,
            'jumlah' => $master['jumlah'],
            'total' => $master['total'],
            'diskon' => $master['diskon']['final_diskon'],
            'ppn' => $master['ppn'],
            'ppn_total' => $master['ppn_total'],
            'grand_total' => $master['grand_total'],
            'jenis_pembayaran' => $master['bayar']['jenis_pembayaran'],
            'no_transaksi' => $master['bayar']['no_transaksi'],
            'bayar' => $master['bayar']['nominal'],
            'kembalian' => $master['kembalian'],
            'status' => $master['kembalian'] < 0 ? "belum lunas" : "lunas",
            'member_id' => $member['id'],
            'nama_member' => $member['nama'],
        ])->id;

        collect($master['produk'])->map(
            function ($q) use ($id) {
                $q['transaksi_id'] = $id;
                $q['created_at'] = date('Y-m-d H:i:s');
                TransaksiDetail::create($q);
            }
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $final = [
            'jenis_pembayaran' => $request->lunas['jenis_pembayaran'],
            'no_transaksi' => $request->lunas['no_transaksi'],
            'kembalian' => ($transaksi->bayar + $request->lunas['nominal']) - $request->grand_total,
            'bayar' => $request->lunas['nominal'] + $transaksi->bayar,
        ];
        $final['status'] = $final['bayar'] < 0 ? 'belum lunas' : 'lunas';
        // dd($final, $request->all());
        $transaksi->update($final);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }

    public function lock()
    {
        User::find(auth()->user()->id)->update(['lock' => 'aktif']);
        return Inertia::render('lock');
    }
    public function unlock(Request $request)
    {
        $user = auth()->user();
        $cek = [
            'email' => $user->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($cek)) {
            User::find($user->id)->update(['lock' => 'tidak aktif']);
            return redirect()->route('penjualan.index');
        }
        return back()->withErrors('');
    }
}
