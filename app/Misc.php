<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Misc extends Model
{
    /* Relation to Origin */
    public function origin(){
    	return $this->hasMany('App\Origin', 'id_type');
    }
}
