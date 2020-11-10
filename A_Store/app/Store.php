<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';
    protected $fillable = ['nm_toko','alamat', 'kota', 'kd_pos'];
}
