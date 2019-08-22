<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Misc extends Model
{
    /* Relation to Origin */
    public function origins(){
    	return $this->hasMany('it\Origin');
    }
}
 