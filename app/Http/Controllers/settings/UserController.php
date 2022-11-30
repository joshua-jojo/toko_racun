<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $final = $request->all();
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|min:3|email',
        ]);
        if ($request->password != null || $request->repassword != null) {
            $request->validate([
                'password' => "min:4",
                'repassword' => "same:password",
            ]);
            $request['password'] = bcrypt($request->password);
        }
        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'image|mimes:jpg,JPG,jpeg,JPEG,png,PNG'
            ]);

            $nama_image = strtotime(date('YmdHis')) . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('\img\profiles'), $nama_image);
            $nama_image = 'img/profiles/' . $nama_image;
            $final['foto'] = $nama_image;
        }
        $final = array_filter($final, 'strlen');
        $user->update($final);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
