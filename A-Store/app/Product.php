<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['store_id', 'kategori_id', 'thumbnail', 'nm_barang', 'deskripsi', 'harga', 'stok'];

    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function kategori(){
        return $this->belongsTo('App\Kategori');
    }
}
