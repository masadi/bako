@extends('layouts.cetak')
@section('content')
<table width="100%">
	<tr>
		<td width="50%">No: {{$nomor}}</td>
		<td width="50%" class="text-right">Hari/Tanggal : {{hari_ini(date('Y-m-d')).', '.date('d/m/Y')}}</td>
	</tr>
</table>
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
				<td class="text-right">{{rupiah($item->bonus)}}</td>
			</tr>
			<?php
			$_bruto += $item->bruto;
			$_netto += $item->netto;
			$_bonus += $item->bonus;
			?>
		@endforeach
			<tr>
				<td><b>Jumlah</b></td>
				<td class="text-center"><strong>{{$transaksi->count()}}</strong></td>
				<td class="text-center"><strong>{{$_bruto}}</strong></td>
				<td class="text-center"><strong>{{$_netto}}</strong></td>
				<td class="text-right"><strong>{{rupiah($_bonus)}}</strong></td>
			</tr>
	</tbody>
</table>
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
@endsection