<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['icon', 'kategori'];

    public function product()
    {
        return $this->hasMany('App\Product');
    }
}
