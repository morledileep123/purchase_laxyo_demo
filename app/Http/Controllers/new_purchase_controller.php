<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class new_purchase_controller extends Controller
{
    public function new_purchase(){
        return view('new_purchase.purchase-new');
    }
}
