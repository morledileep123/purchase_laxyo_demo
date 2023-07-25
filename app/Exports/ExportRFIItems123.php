<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\item;
use App\prch_itemwise_requs;

class ExportRFIItems implements FromCollection
{
     public function collection() 
     { 
          return prch_itemwise_requs::select('','item_name','item_no','current_stock','m_quantity','quantity_unit','description')->get();
          // return prch_itemwise_requs::select('item_name','item_no','current_stock','m_quantity','quantity_unit','description')->get(); 
     }

      // public function headings(); array
    // {
    //     return [
    //         'Item_name',
    //         'quantity'
    //         'quantity_unit',
    //         'description',
    //         'remark'
    //     ];
    // }

    // public function map($product): array
    // {
    //     return[
    //         $product->Item_name,
    //         $product->quantity,
    //         $product->quantity_unit,
    //         $product->description,
    //         $product->remark,
    //     ];
    // }
}
