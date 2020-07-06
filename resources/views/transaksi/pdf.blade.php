@extends('layouts.cetak')
@section('content')
<table class="table table-bordered" width="100%">
	<thead>
		<tr>
			<th class="text-center">Bagian</th>
			<th style="width: 5%" class="text-center">No</th>
			<th class="text-center">Bruto</th>
			<th class="text-center">Netto</th>
			<th class="text-center">Bonus</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($transaksi as $item)
			<tr>
				<td>{{$item->bagian->nama}}</td>
				<td>{{$item->nomor}}</td>
				<td>{{$item->bruto}}</td>
				<td>{{$item->netto}}</td>
				<td>{{$item->bonus}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@endsection