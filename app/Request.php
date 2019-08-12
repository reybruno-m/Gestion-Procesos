<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    // Relation To Users

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Relation To Origin

    public function origin()
    {
        return $this->belongsTo('App\Origin');
    }

}
