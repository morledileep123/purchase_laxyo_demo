<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\prch_quotationwise_requs;
use App\Purchase_order;
use App\Purchase_order_detail;
use App\User;
use App\Send_quotation;
use App\Send_quotation_Vendor_detail;
use App\Item_quotation_data;
use App\prch_itemwise_requs;
use App\Imports\QuotationImport;
use App\Events\NewTestCreate;
use App\Listeners\NewTestListener;
use DB;
use Carbon\Carbon;
use PDF;
Use Mail;
use \App\Mail\SendQuotationToVendors;
use \App\Notifications\WelocmeNotification;
use \App\Notifications\InformNotification;
use Storage;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class TestNotification extends Controller
{
    public function index()
    {
        $user = User::find(222);
        Notification::send($user, New WelocmeNotification);
        dd('Done');
    }

    public function notify()
    {
        if (auth()->user()) {
            $user = User::find(222);
            auth()->user()->notify(New InformNotification($user));
        }
        dd('Done');  
    }

    public function newtestnoti()
    {
        $user = User::find(222);
        event(New NewTestCreate($user));

        dd('OK');
    }
}
