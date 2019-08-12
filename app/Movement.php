<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{

	/* Relation to State */

    public function state()
    {
        return $this->hasOne('App\State');
    }

	/* Relation to Users */
	
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
