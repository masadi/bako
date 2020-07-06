<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Bagian;
use App\Bonus;
use App\Transaksi;
class AjaxController extends Controller
{
    public function index(Request $request){
        $fungsi = 'list_'.$request->route('query');
        return $this->{$fungsi}($request);
    }
    public function list_bagian($request){
        $query = Bagian::query();
        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function($item) {
            return '-';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function list_bonus($request){
        $query = Bonus::query();
        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('interval', function($item) {
            return $item->interval_start.'-'.$item->interval_end;
        })
        ->addColumn('action', function($item) {
            return '-';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function list_transaksi($request){
        $query = Transaksi::query()->with('bagian');
        return DataTables::of($query)
        ->addColumn('tanggal', function($item) {
            return date('d/m/Y', strtotime($item->tanggal));
        })
        ->addColumn('bagian', function(Transaksi $transaksi) {
            return $transaksi->bagian->nama;
        })
        ->make(true);
    }
    public function get_bonus(Request $request){
        $bonus = Bonus::where(function($query) use ($request){
            $query->where('interval_start', '<=', $request->netto);
            $query->where('interval_end', '>=', $request->netto);
        })->first();
        return ($bonus) ? $bonus->bonus : 0;
    }
}
