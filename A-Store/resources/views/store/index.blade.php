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
                    <strong>Data Store</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('stores/create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>User</th>
                            <th>Toko</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($stores->count() > 0)
                            @foreach ($stores as $key => $item)
                                <tr>
                                    <td>{{ $stores->firstItem() + $key }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->nm_toko }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->kota }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('stores/' . $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ url('stores/' . $item->id . '/edit') }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ url('stores/' . $item->id) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">Data Kosong</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $stores->links() }}
                {{-- <div class="pull-left">
                    Showing
                    {{ $stores->firstItem() }}
                    to
                    {{ $stores->lastItem() }}
                    of
                    {{ $stores->total() }}
                    entries
                </div>
                <div class="pull-right">
                    {{ $stores->links() }}
                </div> --}}
            </div>
        </div>

    </div>

</div>
@endsection