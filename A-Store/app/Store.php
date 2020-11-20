<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['thumbnail','nm_toko', 'user_id','no_telepon', 'no_rekening', 'pemilik_rekening', 'bank', 'alamat', 'kota', 'kd_pos'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function product(){
        return $this->hasMany('App\Product');
    }

}
