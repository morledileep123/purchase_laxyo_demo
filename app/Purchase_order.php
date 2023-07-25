<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Purchase_order_detail;

class Purchase_order extends Model
{
	use SoftDeletes;
    protected $table = 'prch_purchase_order';
    protected $guarded = [];
    public $timestamps = true;

    public function prch_order(){
        return $this->belongsTo('App\Purchase_order_detail','item_id', 'id');
    }

    // public function prch_order()
    // {
    //     return $this->belongsTo(Purchase_order_detail::class, 'id', 'item_id');
    // }
    
    // public function factory()
    // {
    //     return $this->belongsTo(Purchase_order_detail::class,'id','item_id');
    //     // return $this->belongsTo('App\Purchase_order_detail','id','item_id');
    // }

    public function super_admin(){
        return $this->belongsTo('App\User','super_admin_id');
    }

    public function admin_id(){
        return $this->belongsTo('App\User','user_id');
    }

    public function prch_items(){
        return $this->belongsTo('App\Purchase_order_detail','item_id','id');
    }

}