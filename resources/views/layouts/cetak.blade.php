<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cetak Dokumen</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/bootstrap-3.min.css')}}">
    <style>
    @page {
	    header: page-header;
	    footer: page-footer;
    
    }
    table tr td, table tr th{padding: 5px;}
    </style>
</head>
<body>
	@yield('content')
</body>
</html>
