<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;

use Illuminate\Contracts\View\View;

use App\item;
use App\prch_itemwise_requs;

class ExportRFIItemsView implements FromView
{
    protected $values;

    public function __construct($values)
    {
        dd($values);
        $this->values = $values;
    }

    public function view(): view
    {
        $data = prch_itemwise_requs::whereIn('id',explode(',',$this->values))->get();
        return view('level_two.table',compact('data'));
        
    }
}
