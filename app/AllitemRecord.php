<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllitemRecord extends Model
{
    use SoftDeletes;
     protected $table = 'prch_allitem_record_newbkup';
     protected $guarded = [];

     public function category(){
        return $this->belongsTo('App\item_category', 'cat_id');
    }
     
      public function department(){
        return $this->belongsTo('App\Department', 'dept_id');
    }

    public function unit(){
        return $this->belongsTo('App\unitofmeasurement', 'unit_id');
    }

    public function vendor(){
        return $this->belongsTo('App\vendormain', 'vendor_id');
    }

    public function subcat(){
        return $this->belongsTo('App\Brand', 'sub_cat_id');
    }
}
