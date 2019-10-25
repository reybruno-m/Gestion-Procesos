<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Misc extends Model
{

	protected $table = "misc";

    /* Relation to Task "Priority misc_id" 1:1 */

    public function task(){
    	return $this->hasMany('it\Task');
    }

    /* Relation to Origin 1:1 */
    
    public function origin()
    {
        return $this->hasMany('it\Origin');
    }
}
 