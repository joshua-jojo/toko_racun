<?php

namespace App\Http\Middleware;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        $user = [
            'name' => null,
            'email' => null,
            'foto' => null,
            'lock' => null,
        ];
        if (Auth::check()) {
            $user = Auth::user();
            $user = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'lock' => $user->lock,
                'foto' => url($user->foto),
            ];
        }
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' =>  session()->get('respon'),
            'user' =>  $user,
            'toko' =>  Toko::all()->first(),
        ]);
    }
}
