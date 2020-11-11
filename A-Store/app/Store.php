<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['nm_toko', 'user_id','alamat', 'kota', 'kd_pos'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function product(){
        return $this->hasMany('App\Product');
    }

}
