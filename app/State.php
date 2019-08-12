<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /* Relation to Movements */

    public function movement(){
    	return $this->belongsTo('App\Movement', 'id_state');
    } 
}


