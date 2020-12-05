@extends('main')

@section('title', '')

@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>User</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="#">User</a></li>
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
                    <strong>Data User</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('users/create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Avatar</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center"><img src="{{ $item->avatar }}" alt="" style="width: 120px; hight: 120px;"></td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role }}</td>
                                <td class="text-center">
                                    <a href="{{ url('users/' . $item->id . '/edit') }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <form action="{{ url('users/' . $item->id) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>

    </div>

</div>
@endsection