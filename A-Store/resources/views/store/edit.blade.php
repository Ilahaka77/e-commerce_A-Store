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
                    <li class="active">Edit</li>
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
                    <strong>Edit Store</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('stores') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-chevron-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <form action="{{ url('stores/' . $store->id) }}" method="post" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <label>User</label>
                                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                    <option value="">Pilih</option>
                                    @foreach ($users as $item)
                                    <option value="{{ $item->id }}" {{ old('user_id', $store->user_id) == $item->id ? 'selected' : null }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Thumbnail</label>
                                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" value="{{ old('thumbnail', $store->thumbnail) }}">
                                @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nama Toko</label>
                                <input type="text" name="nm_toko" class="form-control @error('nm_toko') is-invalid @enderror" value="{{ old('nm_toko', $store->nm_toko) }}">
                                @error('nm_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>No Telepon</label>
                                <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon', $store->no_telepon) }}">
                                @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>No Rekening</label>
                                <input type="text" name="no_rekening" class="form-control @error('no_rekening') is-invalid @enderror" value="{{ old('no_rekening', $store->no_rekening) }}">
                                @error('no_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Pemilik Rekening</label>
                                <input type="text" name="pemilik_rekening" class="form-control @error('pemilik_rekening') is-invalid @enderror" value="{{ old('pemilik_rekening', $store->pemilik_rekening) }}">
                                @error('pemilik_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Bank</label>
                                <input type="text" name="bank" class="form-control @error('bank') is-invalid @enderror" value="{{ old('bank', $store->bank) }}">
                                @error('bank')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', $store->alamat) }}">
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kota</label>
                                <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror" value="{{ old('kota', $store->kota) }}">
                                @error('kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kode Pos</label>
                                <input type="number" name="kd_pos" class="form-control @error('kd_pos') is-invalid @enderror" value="{{ old('kd_pos', $store->kd_pos) }}">
                                @error('kd_pos')
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