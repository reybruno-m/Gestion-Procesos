<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public $timestamps = false;

    protected $table = "comments";
    protected $fillable = ['movement_id', 'user_id', 'comment', 'created'];


    /* Relation to Movement 1:N */
    public function movements(){
    	return $this->belongsTo('it\Movement');
    }

    /* Relation to User 1:N */
    public function user(){
        return $this->belongsTo('it\User');
    }

}
