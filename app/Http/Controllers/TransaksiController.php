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
        ])->id;

        $transaksi_detail = collect($master['produk'])->map(
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
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
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
