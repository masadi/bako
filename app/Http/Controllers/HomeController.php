<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use DB;
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transaksi = Transaksi::select(DB::raw('SUM(bruto) as jml_bruto'), DB::raw('SUM(netto) as jml_netto'), DB::raw('SUM(bonus) as jml_bonus'))->first();
        return view('home', compact('transaksi'));
    }
}
