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
                    <li class="active">Add</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="content mt-3">
    <div class="animated fadeIn">

        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <strong>Tambah User</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('users') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <form action="{{ url('users') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Nama </label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Avatar </label>
                                <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" value="{{ old('avatar') }}" autofocus>
                                @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email </label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password </label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" autofocus>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alamat </label>
                                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" autofocus>
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Role </label>
                                <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" value="{{ old('role') }}" autofocus>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection