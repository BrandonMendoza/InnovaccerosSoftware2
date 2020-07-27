<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        /*Con esto se logra que solo los usuarios con role de ‘user’ o ‘admin’ puedan ingresar en esa vista.*/
        $request->user()->authorizeRoles(['user', 'admin']);
        return view('home');
    }
}
