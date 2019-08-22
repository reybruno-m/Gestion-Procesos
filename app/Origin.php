<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    // Relation To Request
    /*
    public function requests()
    {
        return $this->hasMany('App\Request', 'id_origin');
    }*/

    // Relation To Misc

    public function miscs()
    {
        return $this->belongsTo('it\Misc');
    }
}
 