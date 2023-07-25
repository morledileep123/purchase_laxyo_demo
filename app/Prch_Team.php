<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

use App\Prch_Team_Person;

class Prch_Team extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use SoftDeletes;
    
    protected $table = 'prch_team';
    protected $guarded = [];

    // public function prch_teams(){
        // return $this->belongsToMany(Prch_Team_Person::class);
        // return $this->hasMany('App\Prch_Team_Person','team_id','id');
    // }

    // public function prch_teams()
    // {
    //     return $this->hasMany('App\Prch_Team_Person','id','team_id');
    // }

    public function post(){
        return $this->belongsTo('App\Prch_Team_Person','id','team_id');
    }

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
