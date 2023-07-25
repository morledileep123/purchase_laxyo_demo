<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteName extends Model
{
    /*protected $fillable = [
        'name', 'description'
    ];*/
    protected $guarded = [];
    protected $table = 'site_name';

    protected $fillable = [
        'id', 'name'
    ];
}
