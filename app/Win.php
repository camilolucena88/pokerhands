<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Win extends Model
{
    public function round()
    {
        return $this->belongsTo('App\Round');
    }
}
