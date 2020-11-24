@extends('main')

@section('title', '')

@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Kategori</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="#">Kategori</a></li>
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
                    <strong>Tambah Kategori</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('kategoris') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <form action="{{ url('kategoris') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Icon </label>
                                <input type="file" name="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon') }}" autofocus>
                                @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kategori </label>
                                <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" autofocus>
                                @error('kategori')
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