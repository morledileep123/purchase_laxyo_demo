<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsigneePersonDetails extends Model
{
    /*protected $fillable = [
        'name', 'description'
    ];*/
    protected $guarded = [];
    protected $table = 'prch_consignee_person_details';
}
