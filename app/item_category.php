<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class item_category extends Model
{
    /*protected $fillable = [
        'name', 'description'
    ];*/
     use SoftDeletes;
    protected $guarded = [];
    protected $table = 'prch_item_categories';
}
