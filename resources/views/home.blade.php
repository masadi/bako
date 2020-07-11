@extends('adminlte::page')

@section('title', 'eBako | Halaman Utama')

@section('content_header')
<h1 class="m-0 text-dark">Halaman Utama</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$transaksi->jml_bruto}}</h3>

                                <p>Bruto</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$transaksi->jml_netto}}</h3>

                                <p>Netto</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$transaksi->jml_bonus}}</h3>

                                <p>Bonus</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
        </div>
    </div>
</div>
@stop