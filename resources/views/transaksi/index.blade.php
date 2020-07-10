@extends('adminlte::page')

@section('title', config('adminlte.title').' | Data Transaksi')

@section('content_header')
<div class="container-fluid">
	<div class="row mb-2">
		<div class="col-sm-6">
			<h1 class="m-0 text-dark">Data Transaksi</h1>
		</div>
		<div class="col-sm-6">
			<a href="{{route('transaksi.tambah')}}" class="toggle-modal btn btn-primary float-right">Tambah Transaksi</a>
			<a href="{{route('transaksi.download')}}" class="mr-2 toggle-modal btn btn-success float-right">Download Transaksi</a>
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
							<th class="text-center">Tanggal</th>
							<th class="text-center">Bagian</th>
							<th style="width: 5%" class="text-center">No</th>
							<th class="text-center">Bruto</th>
							<th class="text-center">Netto</th>
							<th class="text-center">Bonus</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div id="modal_content" class="modal"></div>
</div>
@stop
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Moment', true)
@section('plugins.Daterangepicker', true)
@section('plugins.Datepicker', true)
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
        "ajax": "{{ route('api.datatables', ['query' => 'transaksi']) }}",
		"columns": [
			{ "data": "tanggal", "name": "tanggal" },
            { "data": "bagian", "name": "bagian.nama" },
			{ "data": "nomor", "name": "nomor" },
			{ "data": "bruto", "name": "bruto" },
			{ "data": "netto", "name": "netto" },
			{ "data": "bonus", "name": "bonus" },
			{ "data": "actions", "name": "actions", "orderable": false, "className": "text-center" },
        ],
		"fnDrawCallback": function(oSettings){
			turn_on_icheck();
		}
    });
	$('a.toggle-select').click(function(e) {
		e.preventDefault();
		Swal.fire({
			title: 'Select field validation',
			input: 'select',
			inputOptions: {
				'Fruits': {
				apples: 'Apples',
				bananas: 'Bananas',
				grapes: 'Grapes',
				oranges: 'Oranges'
				},
				'Vegetables': {
				potato: 'Potato',
				broccoli: 'Broccoli',
				carrot: 'Carrot'
				},
				'icecream': 'Ice cream'
			},
			inputPlaceholder: 'Select a fruit',
			showCancelButton: true,
			inputValidator: (value) => {
				return new Promise((resolve) => {
				if (value === 'oranges') {
					resolve()
				} else {
					resolve('You need to select oranges :)')
				}
				})
			}
			})
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