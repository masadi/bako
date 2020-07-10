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
        ->addColumn('actions', function($item) {
            $links = '<div class="btn-group dropleft">';
			$links .= '<button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Aksi </button>';
			$links .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
			$links .= '<a class="dropdown-item toggle-modal" href="'.route('transaksi.edit', ['id' => $item->id]).'"><i class="fas fa-pencil-alt"></i> Ubah</a></a>';
			$links .= '<a class="dropdown-item confirm" href="'.route('transaksi.delete', ['id' => $item->id]).'"><i class="fas fa-trash"></i> Hapus</a>';
			$links .= '</div>';
			$links .= '</div>';
            return $links;
        })
        ->rawColumns(['actions'])
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
