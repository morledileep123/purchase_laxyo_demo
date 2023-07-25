<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_quotation_data extends Model
{
    protected $guarded = [];
    protected $table = 'items_quotation_data';

    protected $fillable = [
        'item_id', 'rfq_no','rfq_id', 'item_name','quantity','quantity_unit','description','remark'
    ];
}