<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    
    public $timestamps = false;

    protected $table = "movements";
    protected $fillable = ['request_id', 'user_id', 'state_id', 'description', 'taken', 'finalized'];

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
