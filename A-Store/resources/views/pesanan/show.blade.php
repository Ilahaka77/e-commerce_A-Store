@extends('main')

@section('title', 'Pesanan')

@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Pesanan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="#">Pesanan</a></li>
                    <li><a href="#">Data</a></li>
                    <li class="active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="content mt-3">

    <div class="animated fadeIn">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <strong>Detail Pesanan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('pesanans') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-chevron-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive">
                
                <div class="row">
                    <div class="col-md-8 offset-md-2">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Product</th>
                                    <td class="text-center"><img src="{{ $pesanan->product->thumbnail }}" style="width: 100px; height: 100px;" alt=""></td>
                                </tr>
                                <tr>
                                    <th style="width:30%">Nama Product</th>
                                    <td class="text-center">{{ $pesanan->product->nm_barang }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Product</th>
                                    <td class="text-center">{{ $pesanan->jumlah }}</td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td class="text-center">Rp. {{ number_format($pesanan->harga) }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td class="text-center">{{ $pesanan->keterangan }}</td>
                                </tr>
                                <tr>
                                    <th>Pengiriman</th>
                                    <td class="text-center">{{ $pesanan->pengiriman }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td class="text-center">{{ $pesanan->status }}</td>
                                </tr>
                                <tr>
                                    <th>Bukti Pembayaran</th>
                                    <td class="text-center">{{ $pesanan->bukti_bayar }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection