<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'deleted_at'
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

    public function prchmanager(){
        return $this->belongsTo('App\Role_user','id','user_id')->where('role_id','=','22');
    }

    public function prchadmin(){
        return $this->belongsTo('App\Role_user','id','user_id')->where('role_id','=','20');
    }

    public function prchsuperadmin(){
        return $this->belongsTo('App\Role_user','id','user_id')->where('role_id','=','4');
    }

    public function storeadmin(){
        return $this->belongsTo('App\Role_user','id','user_id')->where('role_id','=','28');
    }

    public function prchuser(){
        return $this->belongsTo('App\Role_user','id','user_id')->where('role_id','=','23');
    }

    public function prchaccountant(){
        return $this->belongsTo('App\Role_user','id','user_id')->where('role_id','=','16');
    }

    
}
