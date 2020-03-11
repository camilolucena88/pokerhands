<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function hand()
    {
        return $this->belongsToMany('App\Hand');
    }
}
