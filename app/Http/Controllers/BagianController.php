<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bagian;
use Validator;
class BagianController extends Controller
{
    public function index(){
        return view('bagian.index');
    }
    public function tambah(){
        return view('bagian.tambah');
    }
    public function simpan(Request $request){
        $messages = [
            'required' => ':attribute wajib di isi.',
            'unique' => ':attribute sudah ada di database.',
            'max' => 'maksimal :attribute 255 karakter.',
        ];
        Validator::make(request()->all(), [
			'nama' => 'required|unique:bagian|max:255',
		 ],
		$messages
		)->validate();
        $create = Bagian::create([
            'nama' => $request->nama,
        ]);
        if($create){
            $response = [
                'title' => 'Berhasil',
                'text' => 'Data Bagian berhasil disimpan',
                'icon' => 'success',
            ];
        } else {
            $response = [
                'title' => 'Gagal',
                'text' => 'Data Bagian gagal disimpan',
                'icon' => 'error',
            ];
        }
        return response()->json($response);
    }
}
