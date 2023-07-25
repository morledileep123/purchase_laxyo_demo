<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GRR_Payment extends Model
{
    use SoftDeletes;
    protected $deleted_at = ['deleted_at'];
    protected $table = 'grr_payment';
}
