<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['kategori'];

    public function product(){
        return $this->hasOne('App\Product');
    }
}
