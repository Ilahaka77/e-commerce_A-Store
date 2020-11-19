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
                                    <th style="width:30%">User</th>
                                    <td>{{ $store->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Store</th>
                                    <td>{{ $store->nm_toko }}</td>
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

            </div>
        </div>

    </div>

</div>
@endsection