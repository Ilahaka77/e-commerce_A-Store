<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'store_id', 'product_id', 'jumlah', 'harga', 'keterangan', 'status'];
}
