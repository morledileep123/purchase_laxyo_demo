<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specifications extends Model
{

    use SoftDeletes;
    protected $fillable = ['id',
        'name'
    ];
    protected $guarded = [];
    protected $table = 'prch_item_specifications';

     public function specificationname(){
        return $this->belongsTo('App\item', 'specification_name');
    }
}



