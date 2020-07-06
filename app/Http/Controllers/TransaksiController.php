<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Bagian;
use Validator;
class TransaksiController extends Controller
{
    public function index(){
        return view('transaksi.index');
    }
    public function tambah(){
        $all_bagian = Bagian::get();
        return view('transaksi.tambah', compact('all_bagian'));
    }
    public function simpan(Request $request){
        $messages = [
            'required' => ':attribute wajib di isi.',
            'numeric' => ':attribute harus berupa angka.',
        ];
        Validator::make(request()->all(), [
            'bagian_id' => 'required',
            'nomor' => 'required|numeric',
            'bruto' => 'required|numeric',
            'netto' => 'required|numeric',
            'bonus' => 'required|numeric',
		 ],
		$messages
		)->validate();
        $create = Transaksi::create([
            'bagian_id' => $request->bagian_id,
            'nomor' => $request->nomor,
            'bruto' => $request->bruto,
            'netto' => $request->netto,
            'bonus' => $request->bonus,
        ]);
        if($create){
            $response = [
                'title' => 'Berhasil',
                'text' => 'Transaksi berhasil disimpan',
                'icon' => 'success',
            ];
        } else {
            $response = [
                'title' => 'Gagal',
                'text' => 'Transaksi gagal disimpan',
                'icon' => 'error',
            ];
        }
        return response()->json($response);
    }
}
