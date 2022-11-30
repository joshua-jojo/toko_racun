<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transaksi_start = $request->transaksi_start ?: date('Y-m-d');
        $transaksi_end = $request->transaksi_end ?: date('Y-m-d');

        $jumlah_produk = Produk::all()->count();
        $total_transaksi = Transaksi::sum('grand_total');
        $total_pengeluaran = Pengeluaran::sum('nominal');
        $hutang_member = Transaksi::where('status', 'belum lunas')->sum('grand_total');
        $data_transaksi = Transaksi::selectRaw('date_format(created_at,"%d %b %Y") as xaxis')->whereBetween('created_at', [$transaksi_start, $transaksi_end])->orderBy('created_at')->get()->groupBy('xaxis')->map(function ($q, $key) {
            return $q->count();
        });
        $transaksi = [
            'categories' => $data_transaksi->keys()->all(),
            'chart_data' => $data_transaksi->values()->all(),
            'transaksi_start' => $transaksi_start,
            'transaksi_end' => $transaksi_end,
        ];
        // dd($data_transaksi);

        $master = [
            'jumlah_produk' => $jumlah_produk,
            'total_transaksi' => $total_transaksi,
            'total_pengeluaran' => $total_pengeluaran,
            'hutang_member' => $hutang_member,
            'chart_transaksi' => $transaksi,
        ];
        // dd($master);
        return Inertia::render('dashboard', [
            'master' => $master
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
