<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProdukController extends Controller
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
        $produk = Produk::with(['kategori', 'satuan'])->where('nama', 'like', '%' . $cari . '%')
            ->orWhere('harga_jual', 'like', '%' . $cari . '%')
            ->orWhere('harga_beli', 'like', '%' . $cari . '%')
            ->orWhere('stok', 'like', '%' . (int) $cari . '%')
            ->orWhereHas('kategori', function ($q) use ($cari) {
                $q->where('kategori', 'like', '%' . $cari . '%');
            })
            ->orWhereHas('satuan', function ($q) use ($cari) {
                $q->where('satuan', 'like', '%' . $cari . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($show)
            ->withQueryString();
        return Inertia::render('produk', ['produk' => $produk, 'cari' => $cari, 'show' => $show, 'kategori' => Kategori::all(), 'satuan' => Satuan::all()]);
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
            'nama' => 'required|min:3|unique:produks',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'stok' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
        ]);
        Produk::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'nama' => 'required|min:3',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'stok' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
        ]);
        $data['nama'] == $produk->nama ? $produk->nama : $request->validate(['nama' => 'unique:produks']);
        $produk->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
    }
}
