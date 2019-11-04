<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    
    public $timestamps = false;

    protected $table = "movements";
    protected $fillable = ['task_id', 'user_id', 'state_id', 'description', 'taken', 'finalized'];


    /* Relation to Tasks 1:N */
    public function task(){
        return $this->belongsTo('it\Task');
    }

    /* Relation to User 1:N */
    public function user(){
        return $this->belongsTo('it\User');
    }

    /* Relation to State 1:N */
    public function state(){
        return $this->belongsTo('it\State');
    }
    
    /* Relation to Comments  1:N */
    public function comments(){ 
        return $this->hasMany('it\Comment');
    }
}