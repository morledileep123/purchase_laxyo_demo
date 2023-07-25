<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Prch_Notifications extends Model
{
     use SoftDeletes;
     protected $table = 'notificati';

     public function group()
     {
         return $this->belongsTo('App\User');
     }
}
