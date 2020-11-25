@extends('main')

@section('title', '')

@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Product</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="#">Product</a></li>
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
                    <strong>Detail Product</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('products') }}" class="btn btn-secondary btn-sm">
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
                                    <th>Thumbnail</th>
                                    <td class="text-center"><img src="{{ $product->thumbnail }}" style="width: 250px; height: 250px;" alt=""></td>
                                </tr>
                                <tr>
                                    <th style="width:30%">Nama Barang</th>
                                    <td class="text-center">{{ $product->nm_barang }}</td>
                                </tr>
                                <tr>
                                    <th>Store</th>
                                    <td class="text-center">{{ $product->store->nm_toko }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td class="text-center">{{ $product->kategori->kategori }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td class="text-center">{{ $product->deskripsi }}</td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td class="text-center">Rp. {{ number_format($product->harga ) }}</td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td class="text-center">{{ $product->stok }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Created at</th>
                                    <td>{{ $product->created_at }}</td>
                                </tr> --}}
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection