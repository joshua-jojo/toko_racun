<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
        $supplier = Supplier::latest()
            ->where('nama', 'like', '%' . $cari . '%')
            ->orWhere('alamat', 'like', '%' . $cari . '%')
            ->orWhere('telp', 'like', '%' . $cari . '%')
            ->paginate($show)
            ->withQueryString();
        return inertia()->render('supplier', ['supplier' => $supplier, 'cari' => $cari, 'show' => $show,]);
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
            'nama' => 'required|unique:suppliers',
            'telp' => 'required|unique:suppliers',
            'alamat' => 'required',
        ]);

        Supplier::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
        ]);
        if ($request->nama != $supplier->nama) {
            $request->validate([
                'nama' => 'unique:suppliers'
            ]);
        }
        if ($request->telp != $supplier->telp) {
            $request->validate([
                'telp' => 'unique:suppliers'
            ]);
        }
        $supplier->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
    }
}
