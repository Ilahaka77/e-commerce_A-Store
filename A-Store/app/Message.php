<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    protected $fillable = ['from', 'to', 'message', 'is_read'];

    public function user(){
        return $this->belongsTo('App\Users');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
        ->diffForHumans();
    }
}
