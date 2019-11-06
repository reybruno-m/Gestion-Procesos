<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $table = "tasks";
    protected $fillable = ['description', 'misc_id', 'user_id', 'origin_id', 'destinity_id', 'state', 'created_at', 'updated_at'];
   
    # protected $with = ['movementsRel', 'miscsRel', 'usersRel', 'originsRel'];

    /* Relation to Movements  1:N */
    public function movements(){
        return $this->hasMany('it\Movement');
    }

    /* Relation to user  1:N */
    public function user(){
        return $this->belongsTo('it\User');
    }

    /* Relation to Priority "In Misc" 1:N */
    public function misc(){
        return $this->belongsTo('it\Misc');
    }

    /* Relation to Origins  */
    public function origin(){
        return $this->belongsTo('it\Origin');
    }


    /* Relation to Origin, Destinity  */
    public function destinity(){
        return $this->belongsTo('it\Origin');
    }

}