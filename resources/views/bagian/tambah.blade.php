@extends('layouts.modal')

@section('title', 'Tambah Data Bagian')
@section('content')
<div class="alert alert-danger alert-error" style="display: none;"></div>
<div class="form-group row">
	<label for="nama" class="col-sm-2 col-form-label">Nama</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="nama" placeholder="Nama Bagian">
	</div>
</div>
@endsection
@section('footer')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="simpan">Simpan</button>
@endsection
@section('js')
	<script>
		$('#simpan').click(function(){
			$.ajax({
				url: '{{route('bagian.simpan')}}',
				type: 'post',
				data: {nama:$('#nama').val()},
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