<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users(){
    	return $this->belongsToMany('it\User');
    }
}
