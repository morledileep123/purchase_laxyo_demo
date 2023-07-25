<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorsItems extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'prch_vendors_items';
}
