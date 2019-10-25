<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /* Relation to Movements */

    public function movement(){
    	return $this->belongsTo('it\Movement', 'state_id');
    } 
}


