<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    public $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "email",
        "password",
        "licencia_id",
        "admin",
        "nombre",
        "role_id",
        "created_by"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function cortes(){
        return $this->hasMany('App\Model\Corte', 'created_by');
    }
    public function ventas(){
        return $this->hasMany('App\Model\Venta', 'created_by');
    }
    public function traspasos(){
        return $this->hasMany('App\Model\Traspaso', 'created_by');
    }
}
