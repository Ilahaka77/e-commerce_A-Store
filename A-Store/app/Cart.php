<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = ['user_id', 'store_id', 'product_id', 'jumlah', 'harga', 'keterangan'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function product(){
        return $this->belongsTo('App\Store');
    }
}
