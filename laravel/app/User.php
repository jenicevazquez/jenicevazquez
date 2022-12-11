<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','licencia_id','role_id','admin','imagen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFotoAttribute(){

        $foto = storage_path() . '/data/' . $this->licencia_id . '/' . $this->imagen;
        $fotopublica = url( 'storage/data_' . $this->licencia_id . '_' . $this->imagen);

        if(is_file($foto) && file_exists($foto)){
            return $fotopublica;
        }else{

            return asset('/img/user2-160x160.jpg');
        }
    }


}
