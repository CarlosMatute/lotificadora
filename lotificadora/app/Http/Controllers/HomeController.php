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
    public function index()
    {
        return view('home');
    }
    public function registrar_residenciales()
    {
        return view('registrarResidenciales/registrarResidenciales');
    }
    public function registrar_clientes()
    {
        return view('registrarClientes/registrarClientes');
    }
    public function vender_lotes()
    {
        return view('venderLotes/venderLotes');
    }
}
