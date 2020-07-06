@extends('adminlte::page')

@section('title', 'eBako | Data Bagian')

@section('content_header')
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Data Bagian</h1>
			</div>
			<div class="col-sm-6">
				<a href="{{route('bagian.tambah')}}" class="toggle-modal btn btn-primary float-right">Tambah Bagian</a>
			</div>
		</div>
	</div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%" class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th style="width: 5%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
	<div id="modal_content" class="modal"></div>
@stop
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.select2').select2({theme:'bootstrap4'});
	var oTable = $('#datatable').DataTable( {
		"ordering": false,
		"retrieve": true,
		"processing": true,
        "serverSide": true,
        "ajax": "{{ route('api.datatables', ['query' => 'bagian']) }}",
		"columns": [
            { "data": "DT_RowIndex", "name": "DT_RowIndex", "orderable" : false, className: 'text-center' },
            { "data": "nama", "name": "nama" },
			{ "data": "action", "orderable": false },
        ],
		"fnDrawCallback": function(oSettings){
			turn_on_icheck();
		}
    });
	function turn_on_icheck(){
	$('a.toggle-modal').bind('click',function(e) {
			e.preventDefault();
			var url = $(this).attr('href');
			if (url.indexOf('#') == 0) {
				$('#modal_content').modal('open');
				$('.editor').wysihtml5();
			} else {
				$.get(url, function(data) {
					$('#modal_content').modal();
					$('#modal_content').html(data);
				});
			}
		});
		$('a.confirm').bind('click',function(e) {
			e.preventDefault();
			var url = $(this).attr('href');
			Swal.fire({
				title: 'Apakah Anda yakin?',
				text: "Tindakan ini tidak dapat dikembalikan!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Batal',
				confirmButtonText: 'Yakin!',
				showLoaderOnConfirm: true,
				preConfirm: () => {
					return fetch(url).then(response => {
						return response.json()
					}).catch(error => {
						Swal.showValidationMessage(
							`Request failed: ${error}`
						)
					})
				},
				allowOutsideClick: () => !Swal.isLoading()
			}).then((result) => {
				Swal.fire({
					title: result.value.title, 
					text: result.value.text,
					icon: result.value.icon, 
					allowOutsideClick: false,
				}).then((result) => {
					oTable.ajax.reload(null, false);
				});
			});
		});
	}
</script>
@endsection