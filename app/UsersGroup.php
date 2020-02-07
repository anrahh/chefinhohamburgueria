<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersGroup extends Model
{
    protected $table = "users_group";
    

    public function users(){
        return $this->hasMany('App\Users');
    }   //
}
