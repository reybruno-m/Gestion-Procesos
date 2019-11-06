<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    protected $table = "origins";

    protected $fillable = ['misc_id', 'name', 'state'];


    /* Relation to Tasks 1:N  */
    public function tasks(){
        return $this->hasMany('it\Task');
    }


    /* Relation To Misc 1:N*/
    public function misc()
    {
        return $this->belongsTo('it\Misc');
    }



    /* Relation to Task 1:N */
    public function task(){
        return $this->belongsTo('it\Task');
    }
}
 