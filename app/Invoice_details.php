<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice_details extends Model
{
    use SoftDeletes;
    protected $deleted_at = ['deleted_at'];
    protected $table = 'prch_invoice_details';
    protected $guarded = [];  
}
