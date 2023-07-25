<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Send_quotation extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'send_quotation';

    protected $fillable = [
        'rfq_id', 'date','delivery_address', 'delivery_date','subject','person_name','user_id','sign','send_email'
    ];
}
