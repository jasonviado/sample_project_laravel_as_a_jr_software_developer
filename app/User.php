<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
    public function getName($id){
        $members_name = User::whereIn('id',$id)->get();
        return $members_name;
    }

    public function allUserId(){
        $user = User::all();
        $id = [];
        foreach($user as $key => $val){
            $id[$key] = $val->id;
        }
        return $id;
    }

}
