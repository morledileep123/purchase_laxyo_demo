<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Purchase_order;

class Purchase_order_detail extends Model
{
    protected $guarded = [];
    protected $table = 'prch_order_items_detail';

    // public function post()
    // {
    //     return $this->belongsTo(Purchase_order::class);
    // }

    // public function prch_order()
    // {
    //     return $this->belongsTo('App\Purchase_order');
    // }

    public function prch_orders()
    {
        return $this->hasMany(Purchase_order::class, 'item_id', 'id');
    }
        
}
