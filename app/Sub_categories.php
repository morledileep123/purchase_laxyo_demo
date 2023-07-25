<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Sub_categories extends Model
{
     use SoftDeletes;
    /*protected $fillable = [
        'item_number', 'description', 'unit_id', 'category_id', 'title', 'brand', 'department'
    ];*/
    protected $guarded = [];
    protected $table = 'prch_subcategories';
    
    
}
