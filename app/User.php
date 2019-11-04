<?php

namespace it;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* Desencadena las validaciones, en caso de no existir un rol, retorna un abort. */
    public function authorizedRoles($roles){
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'Esta accion no esta autorizada.');
    }

    /* Valida si el usuario tiene solo 1 rol o mas de uno. */
    public function hasAnyRole($roles){
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    /* Valida si el usuario tiene relacionado un rol. */
    public function hasRole($role){
        if ($this->roles()->where('name','=',$role)->first()) {
            return true;
        }
        return false;
    }

    /* Relation to Roles */
    public function roles(){
        return $this->belongsToMany('it\Role');
    }


    /* Relation to Task 1:N */

    public function tasks(){
        return $this->hasMany('it\Task');
    }

    
    /* Relation to Movements 1:N */

    public function movements(){
        return $this->hasMany('it\Movement');
    }

    /* Relation to Comments 1:N */

    public function comments(){
        return $this->hasMany('it\Comment');
    }

}
