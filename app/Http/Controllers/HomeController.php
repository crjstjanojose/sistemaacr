<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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

        $pendentes1 = DB::table('encomendas')
        ->where([
        ['situacao_pedido', '=', 'Pendente'],
        ])->count();


        $pendentes = DB::table('encomendas')
        ->where([
        ['situacao_pedido', '=', 'Pendente'],
        ['deleted_at', '<>', 'IS NULL'],
        ])->count();

        $pendentes = $pendentes1 - $pendentes;
        $solicitadas = DB::table('encomendas')->where('situacao_pedido', 'Solicitado')->count();
        $entregues = DB::table('encomendas')->where('situacao_pedido', 'Entregue')->count();

        return view('home',compact('pendentes','solicitadas','entregues'));
    }
}
