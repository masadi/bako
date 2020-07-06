@extends('layouts.modal')

@section('title', 'Tambah Transaksi')
@section('content')
<div class="alert alert-danger alert-error" style="display: none;"></div>
<div class="form-group row">
	<label for="bagian_id" class="col-sm-2 col-form-label">Interval</label>
	<div class="col-sm-10">
		<select id="bagian_id" class="select2 form-control">
			<option value="">== Pilih Bagian ===</option>
			@foreach ($all_bagian as $bagian)
			<option value="{{$bagian->id}}">{{$bagian->nama}}</option>
			@endforeach
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="nomor" class="col-sm-2 col-form-label">Nomor</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="nomor" placeholder="Nomor">
	</div>
</div>
<div class="form-group row">
	<label for="bruto" class="col-sm-2 col-form-label">Bruto</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="bruto" placeholder="Bruto">
	</div>
</div>
<div class="form-group row">
	<label for="netto" class="col-sm-2 col-form-label">Netto</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="netto" placeholder="Netto">
	</div>
</div>
<div class="form-group row">
	<label for="bonus" class="col-sm-2 col-form-label">Bonus</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="bonus" placeholder="Bonus">
	</div>
</div>
@endsection
@section('footer')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="simpan">Simpan</button>
@endsection
@section('js')
	<script>
		$('.select2').select2({theme:'bootstrap4'})
		$('#bruto').keyup(function(){
			var bruto = $(this).val();
			var netto = bruto - 8;
			$.ajax({
				url: '{{route('api.get_bonus')}}',
				type: 'post',
				data: {
					netto:netto,
				},
				success: function(response) {
					$('#bonus').val(response)
				}
			});
			$('#netto').val(netto);
		})
		$('#simpan').click(function(){
			$.ajax({
				url: '{{route('transaksi.simpan')}}',
				type: 'post',
				data: {
					bagian_id:$('#bagian_id').val(),
					nomor:$('#nomor').val(),
					bruto:$('#bruto').val(),
					netto:$('#netto').val(),
					bonus:$('#bonus').val(),
				},
			}).done(function(response){
				console.log(response);
				$('.alert-error').hide();
            	$('.alert-error').html('');
				Swal.fire(
                    response.title,
                    response.text,
                    response.icon
                ).then((result) => {
					$('#modal_content').modal('hide');
					$('#datatable').DataTable().ajax.reload();
                });
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