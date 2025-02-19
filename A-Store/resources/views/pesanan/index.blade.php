@extends('main')

@section('title', '')

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
                    <li class="active">Data</li>
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
                    <strong>Data Pesanan</strong>
                </div>
                {{-- <div class="pull-right">
                    <a href="{{ url('pesanans/create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div> --}}
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Product</th>
                            <th>Nama Product</th>
                            <th>Jumlah</th>
                            <th>harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td class="text-center"><img src="{{ $item->product->thumbnail }}" style="width: 75px; height: 75px;" alt=""></td>
                                <td>{{ $item->product->nm_barang }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp. {{ number_format($item->harga) }}</td>
                                <td>
                                    {{-- {{ $item->status }} --}}
                                    @if ($item->status == 'pembayaran')
                                        Belum di bayar
                                    @elseif($item->status == 'packing')
                                        Sedang di kemas
                                    @elseif($item->status == 'sudah dibayar')
                                        Sudah di bayar
                                    @elseif($item->status == 'pengiriman')
                                        Sedang di kirim
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('pesanans/' . $item->id) }}" class="btn btn-light btn-sm">
                                        <i class="fa fa-pencil-square-o">detail</i>
                                    </a>
                                    @if ($item->status == 'packing')
                                    <a href="{{ url('kd_resi/' . $item->id) }}">kirim</a></li>
                                    @elseif($item->status == 'sudah dibayar')
                                    <a href="{{ url('confirmpay/' . $item->id) }}" onclick="event.preventDefault();document.getElementById('confirm-form').submit();">confirm</a></li>
                                    <form id="confirm-form" action="{{ url('confirmpay/' . $item->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('put')
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pesanans->links() }}
            </div>
        </div>

    </div>

</div>
@endsection