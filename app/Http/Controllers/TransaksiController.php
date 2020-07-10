<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use App\Transaksi;
use App\Bagian;
use Validator;
use PDF;
class TransaksiController extends Controller
{
    public function index(){
        return view('transaksi.index');
    }
    public function tambah(){
        $all_bagian = Bagian::get();
        return view('transaksi.tambah', compact('all_bagian'));
    }
    public function edit($id){
        $all_bagian = Bagian::get();
        $transaksi = Transaksi::find($id);
        return view('transaksi.edit', compact('all_bagian', 'transaksi'));
    }
    public function update(Request $request, $id){
        $messages = [
            'required' => ':attribute wajib di isi.',
            'numeric' => ':attribute harus berupa angka.',
        ];
        Validator::make(request()->all(), [
            'tanggal' => 'required',
            'bagian_id' => 'required',
            'nomor' => 'required|numeric',
            'bruto' => 'required|numeric',
            'netto' => 'required|numeric',
            'bonus' => 'required|numeric',
		 ],
		$messages
        )->validate();
        $transaksi = Transaksi::find($id);
        $transaksi->bagian_id = $request->bagian_id;
        $transaksi->tanggal = date('Y-m-d', strtotime($request->tanggal));
        $transaksi->nomor = $request->nomor;
        $transaksi->bruto = $request->bruto;
        $transaksi->netto = $request->netto;
        $transaksi->bonus = $request->bonus;
        if($transaksi->save()){
            $response = [
                'title' => 'Berhasil',
                'text' => 'Transaksi berhasil diperbaharui',
                'icon' => 'success',
            ];
        } else {
            $response = [
                'title' => 'Gagal',
                'text' => 'Transaksi gagal diperbaharui',
                'icon' => 'error',
            ];
        }
        return response()->json($response);
    }
    public function delete($id){
        $delete = Transaksi::find($id);
        if($delete->delete()){
            $response = [
                'title' => 'Berhasil',
                'text' => 'Transaksi berhasil dihapus',
                'icon' => 'success',
            ];
        } else {
            $response = [
                'title' => 'Gagal',
                'text' => 'Transaksi gagal dihapus',
                'icon' => 'error',
            ];
        }
        return response()->json($response);
    }
    public function simpan(Request $request){
        $messages = [
            'required' => ':attribute wajib di isi.',
            'numeric' => ':attribute harus berupa angka.',
        ];
        Validator::make(request()->all(), [
            'tanggal' => 'required',
            'bagian_id' => 'required',
            'nomor' => 'required|numeric',
            'bruto' => 'required|numeric',
            'netto' => 'required|numeric',
            'bonus' => 'required|numeric',
		 ],
		$messages
        )->validate();
        $find = Transaksi::where('tanggal', date('Y-m-d', strtotime($request->tanggal)))->first();
        if($find){
            $nomor_atas = $find->nomor_atas;
        } else {
            $find = Transaksi::orderBy('nomor_atas', 'DESC')->first();
            $nomor_atas = $find->nomor_atas + 1;
        }
        $create = Transaksi::create([
            'bagian_id' => $request->bagian_id,
            'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
            'nomor_atas' => $nomor_atas,
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
    public function download(Request $request){
        if ($request->isMethod('post')) {
            $messages = [
                'required' => ':attribute wajib di isi.',
                'numeric' => ':attribute harus berupa angka.',
            ];
            Validator::make(request()->all(), [
                'start' => 'required',
                'end' => 'required',
                'output' => 'required',
                'nomor' => 'required|numeric',
                'ongkos' => 'required|numeric',
             ],
            $messages
            )->validate();
            $params = [
                'output' => $request->output,
                'start' => $request->start,
                'end' => $request->end,
                'nomor' => $request->nomor,
                'ongkos' => $request->ongkos,
                'bagian_id' => $request->bagian_id,
            ];
            return route('transaksi.output_download', $params);
        } else {
            if($request->route('output')){
                $output = 'download_'.$request->route('output');
                return $this->{$output}($request->route('start'), $request->route('end'), $request->route('nomor'), $request->route('ongkos'), $request->route('bagian_id'));
            }
            $data_bagian = Bagian::get();
            return view('transaksi.download', compact('data_bagian'));
        }
    }
    public function download_pdf($start, $end, $nomor, $ongkos, $bagian_id = NULL){
        $data['transaksi'] = Transaksi::with('bagian')->where(function($query) use ($start, $end, $bagian_id){
            $query->whereBetween('tanggal', [$start, $end]);
            if($bagian_id){
                $query->where('bagian_id', $bagian_id);
            }
        })->orderBy('nomor')->get();
        $data['nomor'] = $nomor;
        $data['ongkos'] = $ongkos;
        $data['start'] = $start;
        $data['end'] = $end;
        //return view('transaksi.pdf', $data);
		$pdf = PDF::loadView('transaksi.pdf', $data);
		return $pdf->stream('document.pdf');
    }
    public function download_excel($start, $end, $nomor, $ongkos, $bagian_id = NULL){
        $transaksi = Transaksi::with('bagian')->where(function($query) use ($start, $end, $bagian_id){
            $query->whereBetween('tanggal', [$start, $end]);
            if($bagian_id){
                $query->where('bagian_id', $bagian_id);
            }
        })->orderBy('nomor')->get();
        //return (new FastExcel($transaksi))->download('file.xlsx');
        return (new FastExcel($transaksi))->download('file.xlsx', function ($transaksi) {
            return [
                'Bagian' => $transaksi->bagian->nama,
                'No' => $transaksi->nomor,
                'Bruto' => $transaksi->bruto,
                'Netto' => $transaksi->netto,
                'Bonus' => $transaksi->bonus,
            ];
        });
    }
}
