<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hands()
    {
        return $this->hasMany('App\Hand');
    }

    public function wins()
    {
        return $this->hasMany('App\Win');
    }
}
