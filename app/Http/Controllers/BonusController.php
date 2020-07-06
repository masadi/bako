<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bonus;
use Validator;
class BonusController extends Controller
{
    public function index(){
        return view('bonus.index');
    }
    public function tambah(){
        return view('bonus.tambah');
    }
    public function simpan(Request $request){
        $messages = [
            'required' => ':attribute wajib di isi.',
            'unique' => ':attribute sudah ada di database.',
            'numeric' => ':attribute harus berupa angka.',
        ];
        Validator::make(request()->all(), [
            'interval_start' => 'required|numeric',
            'interval_end' => 'required|numeric',
            'bonus' => 'required|unique:bonus|numeric',
		 ],
		$messages
		)->validate();
        $create = Bonus::create([
            'interval_start' => $request->interval_start,
            'interval_end' => $request->interval_end,
            'bonus' => $request->bonus,
        ]);
        if($create){
            $response = [
                'title' => 'Berhasil',
                'text' => 'Data Interval Bonus berhasil disimpan',
                'icon' => 'success',
            ];
        } else {
            $response = [
                'title' => 'Gagal',
                'text' => 'Data Interval Bonus gagal disimpan',
                'icon' => 'error',
            ];
        }
        return response()->json($response);
    }
}
