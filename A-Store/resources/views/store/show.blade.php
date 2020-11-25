@extends('main')

@section('title', '')

@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Store</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="#">Store</a></li>
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
                    <strong>Detail Store</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('stores') }}" class="btn btn-secondary btn-sm">
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
                                    <th>Label</th>
                                    <td class="text-center"><img src="{{ $store->thumbnail }}" alt="" style="width: 250px; hight: 250px;"></td>
                                </tr>
                                <tr>
                                    <th style="width:30%">User</th>
                                    <td>{{ $store->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Store</th>
                                    <td>{{ $store->nm_toko }}</td>
                                </tr>
                                <tr>
                                    <th>No Telepon</th>
                                    <td>{{ $store->no_telepon }}</td>
                                </tr>
                                <tr>
                                    <th>No Rekening</th>
                                    <td>{{ $store->no_rekening }}</td>
                                </tr>
                                <tr>
                                    <th>Pemilik Rekening</th>
                                    <td>{{ $store->pemilik_rekening }}</td>
                                </tr>
                                <tr>
                                    <th>Bank</th>
                                    <td>{{ $store->bank }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $store->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Kota</th>
                                    <td>{{ $store->kota }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Pos</th>
                                    <td>{{ $store->kd_pos }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('style/images/slide/promo1.jpg') }}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('style/images/slide/promo4.jpg') }}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('style/images/slide/promo5.jpg') }}" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                        <h4 class="text-center font-weight-bold m-4">Produk Terbaru</h4>

                        <style>
                            .card h5 {
                                margin-top: 2px;
                                margin-bottom: 1px;
                            }
                            .card p {
                                margin-top: 2px;
                                margin-bottom: 1px;
                            }
                            .row .card:hover{
                                box-shadow: 2px 2px 2px rgba(0,0,0,0.4);
                                transform: scale(1,4,1,4);
                            }
                        </style>

                        <div class="row mx-auto">
                            @foreach ($products as $product)
                            <div class="col-md-4">
                                <div class="card m-1" style="width: 200px; hight: 200px;">
                                    <img class="justify-content-center" src="{{ $product->thumbnail }}" class="card-img-top img-fluid" style="width: 250px; hight: 250px;" alt="...">
                                    <div class="card-body">
                                        <h5 class="">{{ $product->nm_barang }}</h5>
                                        <p class="card-text font-weight-bold">Rp. {{ number_format($product->harga) }}</p>
                                        <p class="card-text">{{ $product->deskripsi }}</p>
                                        {{-- <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i> --}}
                                        <p class="card-text font-weight-bold">Stock : {{ $product->stok }}</p>
                                        {{-- <a href="#" class="btn btn-warning btn-sm">Detail</a> --}}
                                        {{-- <a href="#" class="btn btn-danger btn-sm">Rp. {{ number_format($product->harga) }}</a> --}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection