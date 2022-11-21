<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
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
        $pengeluaran = Pengeluaran::selectRaw("*,date_format(tanggal,'%d %M %Y') as waktu")
            ->whereDate(DB::raw('date(tanggal)'), '>=', new DateTime($range['dari']))
            ->whereDate(DB::raw('date(tanggal)'), '<=', new DateTime($range['sampai']))
            ->where('nominal', 'like', '%' . $cari . '%')
            ->where('keterangan', 'like', '%' . $cari . '%')
            ->paginate($show)
            ->withQueryString();
        return inertia()->render('pengeluaran', [
            'pengeluaran' => $pengeluaran,
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
        $data = $request->validate([
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric',
            'keterangan' => 'required',
        ]);
        Pengeluaran::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        //
    }
}
