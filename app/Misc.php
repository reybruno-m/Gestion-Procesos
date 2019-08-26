<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Misc extends Model
{

	protected $table = "misc";

    /* Relation to Origin */
    public function origins(){
    	return $this->hasMany('it\Origin');
    }
}
 