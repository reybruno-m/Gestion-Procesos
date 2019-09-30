<?php

namespace it;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{

    protected $table = "requests";

    protected $fillable = ['description', 'misc_id', 'user_id', 'origin_id', 'created_at', 'updated_at'];

    // Relation To Users

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Relation To Origin

    public function origin()
    {
        return $this->belongsTo('App\Origin');
    }

}
