<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hand extends Model
{
    /**
     * @return HasOne
     */
    public function card()
    {
        return $this->hasOne('App\Card');
    }

    public function round()
    {
        return $this->belongsTo('App\Round');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
