<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

use App\Prch_Team;

class Prch_Team_Person extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'prch_team_person';
    protected $guarded = [];

    // public function post()
    // {
    //     return $this->belongsToMany('App\Prch_Team');
    // }
    

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

    public function prch_users_in_team(){
        return $this->belongsToMany('App\User', 'prch_team_person', 'team_id', 'user_id');
    }
    
}
