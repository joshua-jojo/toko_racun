<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
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
        $member = Member::where('nama', 'like', '%' . $cari . '%')
            ->orWhere('alamat', 'like', '%' . $cari . '%')
            ->orWhere('telp', 'like', '%' . $cari . '%')
            ->orWhere('diskon', 'like', '%' . $cari . '%')
            ->paginate($show)
            ->withQueryString();
        return inertia()->render('member', ['member' => $member, 'cari' => $cari, 'show' => $show,]);
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
            'nama' => 'required|unique:members',
            'alamat' => 'required',
            'telp' => 'required',
            'diskon' => 'required|numeric|min:0|max:100',
        ]);
        Member::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        if ($request->nama != $member->nama) {
            $request->validate([
                'nama' => 'required|unique:members'
            ]);
        }
        if ($request->telp != $member->telp) {
            $request->validate([
                'telp' => 'required|unique:members'
            ]);
        }
        $member->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
    }
}
