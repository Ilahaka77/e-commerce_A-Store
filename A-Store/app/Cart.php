<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = ['user_id', 'store_id', 'product_id', 'jumlah', 'harga', 'keterangan'];
}
