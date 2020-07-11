@extends('layouts.modal')

@section('title', 'Download Transaksi')
@section('content')
<div class="alert alert-danger alert-error" style="display: none;"></div>
<div class="form-group row">
	<label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
	<div class="col-sm-10">
		<div class="input-group">
			<button type="button" class="btn btn-default float-right btn-block" id="tanggal">
				<i class="far fa-calendar-alt"></i> Pilih Tanggal
				<i class="fas fa-caret-down"></i>
			</button>
		</div>
	</div>
</div>
<div class="form-group row">
	<label for="output" class="col-sm-2 col-form-label">Output File</label>
	<div class="col-sm-10">
		<select id="output" class="select2 form-control">
			<option value="">== Pilih Output ===</option>
			<option value="pdf">PDF</option>
			<option value="excel">Excel</option>
		</select>
	</div>
</div>
<!--div class="form-group row">
	<label for="nomor" class="col-sm-2 col-form-label">Nomor</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="nomor">
	</div>
</div-->
<div class="form-group row">
	<label for="ongkos" class="col-sm-2 col-form-label">Ongkos</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="ongkos">
	</div>
</div>
<div class="form-group row">
	<label for="bagian_id" class="col-sm-2 col-form-label">Bagian</label>
	<div class="col-sm-10">
		<select id="bagian_id" class="select2 form-control">
			<option value="">== Pilih Bagian ===</option>
			@foreach ($data_bagian as $bagian)
			<option value="{{$bagian->id}}">{{$bagian->nama}}</option>
			@endforeach
		</select>
	</div>
</div>
<input type="hidden" name="start" id="start">
<input type="hidden" name="end" id="end">
@endsection
@section('footer')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="simpan">Download</button>
@endsection
@section('js')
<script>
	moment.locale('id');
	$('.select2').select2({theme:'bootstrap4'})
	$('#tanggal').daterangepicker(
		{
			ranges   : {
			'Hari ini'       : [moment(), moment()],
			'Kemarin'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 hari terakhir' : [moment().subtract(6, 'days'), moment()],
			'30 hari terakhir': [moment().subtract(29, 'days'), moment()],
			'Bulan ini'  : [moment().startOf('month'), moment().endOf('month')],
			'Bulan kemarin'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			startDate: moment().subtract(29, 'days'),
			endDate  : moment()
		},
		function (start, end) {
			$('#start').val(start.format('YYYY-MM-DD'))
			$('#end').val(end.format('YYYY-MM-DD'))
			$('#tanggal').html('<i class="far fa-calendar-alt"></i> '+start.format('DD MMMM YYYY') + ' s/d ' + end.format('DD MMMM YYYY')+' <i class="fas fa-caret-down"></i>');
		}
	)
	$('#simpan').click(function(){
		$.ajax({
			url: '{{route('transaksi.download')}}',
			type: 'post',
			data: {
				start:$('#start').val(),
				end:$('#end').val(),
				output:$('#output').val(),
				//nomor:$('#nomor').val(),
				ongkos:$('#ongkos').val(),
				bagian_id:$('#bagian_id').val()
			},
		}).done(function(response){
			console.log(response);
			$('.alert-error').hide();
            $('.alert-error').html('');
			window.open(response);
		}).fail(function(data){
			var html = data.responseJSON.message;
			var errors = [];
			$.each(data.responseJSON.errors, function(i, item){
				errors.push(item[0]);
			})
			$('.alert-error').show();
			$('.alert-error').html(errors.join('<br>'));
		});
	})
</script>
@endsection