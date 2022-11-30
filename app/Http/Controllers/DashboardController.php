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
    public function index()
    {
        $jumlah_produk = Produk::all()->count();
        $total_transaksi = Transaksi::sum('grand_total');
        $total_pengeluaran = Pengeluaran::sum('nominal');
        $hutang_member = Transaksi::where('status', 'belum lunas')->sum('grand_total');

        $master = [
            'jumlah_produk' => $jumlah_produk,
            'total_transaksi' => $total_transaksi,
            'total_pengeluaran' => $total_pengeluaran,
            'hutang_member' => $hutang_member,
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
