<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company_site_name extends Model
{
    use SoftDeletes;
    protected $table = 'company_side_name';
    protected $guarded = [];
    public $timestamps = true;
    
}
