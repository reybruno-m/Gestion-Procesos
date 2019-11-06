<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{

    public $timestamps = false;

    protected $table = "departaments";
    protected $fillable = ['name'];


    /* Relation to User 1:N */
    public function user(){
    	return $this->hasMany('it\User');
    }

}
