<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
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
        $pembelian = Pembelian::with(['supplier', 'pembelian_detail.produk.satuan'])->latest()->selectRaw("*,date_format(tanggal,'%d %M %Y') as waktu")
            ->whereDate(DB::raw('date(tanggal)'), '>=', new DateTime($range['dari']))
            ->whereDate(DB::raw('date(tanggal)'), '<=', new DateTime($range['sampai']))
            ->where(function ($query) use ($cari) {
                $query->where('total_item', 'like', '%' . $cari . '%')
                    ->orWhere('total_harga', 'like', '%' . $cari . '%')
                    ->orWhere('diskon', 'like', '%' . $cari . '%')
                    ->orWhere('total_bayar', 'like', '%' . $cari . '%')
                    ->orWhereHas(
                        'supplier',
                        function ($q) use ($cari) {
                            $q->where('nama', 'like', '%' . $cari . '%');
                        }
                    );
            })
            ->paginate($show)
            ->withQueryString();
        return inertia()->render('pembelian', [
            'master_pembelian' => $pembelian,
            'supplier' => Supplier::orderBy('nama', 'asc')->get(),
            'produk' => Produk::with(['satuan'])->selectRaw('*,0 as jumlah')->orderBy('nama', 'asc')->get(),
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
        // dd($request->all(), $request->diskon['final']);
        $pembelian = [
            'tanggal' => date('Y-m-d'),
            'supplier_id' => $request->supplier['id'],
            'total_item' => $request->total_item,
            'total_harga' => $request->total_harga,
            'diskon' => $request->diskon['final'],
            'ppn' => $request->ppn['final'],
            'total_bayar' => $request->total_bayar,
        ];
        $id = Pembelian::create($pembelian)->id;
        foreach ($request->produk as $key => $value) {
            $produk = [
                'pembelian_id' => $id,
                'produk_id' => $value['id'],
                'harga_beli' => $value['harga_beli'],
                'jumlah' => $value['jumlah'],
                'subtotal' => $value['subtotal'],
            ];
            PembelianDetail::create($produk);
            $produk = Produk::find($value['id']);
            $produk->update([
                'stok' => $produk->stok += $value['jumlah']
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }
}
