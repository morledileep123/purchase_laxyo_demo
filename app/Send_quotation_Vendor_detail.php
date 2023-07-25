<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Send_quotation_Vendor_detail extends Model
{
    protected $guarded = [];
    protected $table = 'send_quotati_vendor_detail';

    protected $fillable = [
        'item_id', 'rfq_no','rfq_id', 'company','person_email','address1','state','city'
    ];
}