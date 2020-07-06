<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
class RekapController extends Controller
{
    public function index(){
        return view('rekapitulasi.index');
    }
}
