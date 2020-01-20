<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
         if(Auth::user()->tipo_usuario=='ADMINISTRADOR'){
            return view('administrador.home');
         }
         return view('home');
      }
      public function contruccion(Request $request)
      {
         if(Auth::user()->tipo_usuario=='ADMINISTRADOR'){
            return view('error.error');
         }
         return view('home');
      }
}
