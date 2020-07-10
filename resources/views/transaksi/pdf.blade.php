@extends('layouts.cetak')
@section('content')
<table width="100%">
	<tr>
		<td width="30%">No: {{$nomor}}</td>
		<td width="70%" class="text-right">
			Hari/Tanggal : {{hari_ini($start).', '.date('d/m/Y', strtotime($start))}}
			@if($start != $end)
			s.d {{hari_ini($end).', '.date('d/m/Y', strtotime($end))}}
			@endif
		</td>
	</tr>
</table>
<table class="table table-bordered" width="100%">
	<thead>
		<tr>
			<th class="text-center">Bagian</th>
			<th style="width: 5%" class="text-center">No</th>
			<th class="text-center">Bruto</th>
			<th class="text-center">Netto</th>
			<th class="text-center">Ongkos</th>
			<th class="text-center">Jumlah</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$_bruto = 0;
		$_netto = 0;
		$_bonus = 0;
		?>
		@foreach ($transaksi as $item)
			<tr>
				<td>{{$item->bagian->nama}}</td>
				<td class="text-center">{{$item->nomor}}</td>
				<td class="text-center">{{$item->bruto}}</td>
				<td class="text-center">{{$item->netto}}</td>
				<td class="text-right">{{rupiah($ongkos)}}</td>
				<td class="text-right">{{rupiah($ongkos * $item->netto)}}</td>
			</tr>
			<?php
			$_bruto += $item->bruto;
			$_netto += $item->netto;
			$_bonus += $item->bonus;
			?>
		@endforeach
		<tfoot>
			<tr>
				<th>Sub Total</th>
				<th class="text-center">{{$transaksi->count()}}</th>
				<th class="text-center">{{$_bruto}}</th>
				<th class="text-center">{{$_netto}}</th>
				<th class="text-right">{{rupiah($ongkos)}}</th>
				<th class="text-right">{{rupiah($ongkos * $_netto)}}</th>
			</tr>
		</tfoot>
	</tbody>
</table>
{{--
<table width="100%" border="1">
	<tr>
		<td width="50%" style="border:none"></td>
		<td width="25%" rowspan="3" class="text-right" style="border:none">Ongkos</td>
		<td width="24%" class="text-right" style="border:none">{{rupiah($_netto)}}</td>
	</tr>
	<tr>
		<td width="50%" style="border:none"></td>
		<td width="24%" class="text-right" style="border-top:none;border-left:none;border-right:none">{{rupiah($ongkos)}}</td>
		<td width="1%" rowspan="2" class="text-center" style="border:none">x</td>
	</tr>
	<tr>
		<td width="50%" style="border:none"></td>
		<td width="25%" class="text-right" style="border-bottom:none;border-left:none;border-right:none">{{rupiah($_netto * $ongkos)}}</td>
	</tr>
	<tr>
		<td width="50%" style="border:none"></td>
		<td width="25%" class="text-right" style="border:none">Bonus</td>
		<td width="24%" class="text-right" style="border-top:none;border-left:none;border-right:none">{{rupiah($_bonus)}}</td>
		<td width="1%" rowspan="2" class="text-center" style="border:none">+</td>
	</tr>
	<tr>
		<td width="50%" style="border:none"></td>
		<td width="25%" class="text-right" style="border:none">Sub Total</td>
		<td width="24%" class="text-right" style="border-bottom:none;border-left:none;border-right:none">{{rupiah(($_netto * $ongkos) + $_bonus)}}</td>
	</tr>
</table>
--}}
@endsection