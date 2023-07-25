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
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $values;

    public function __construct($values)
    {
        $this->values = $values;
    }


    public function headings(): array
    {
        return [
          'item_name',
          'm_quantity',
          'quantity_unit',
          'description'
        ];
    }

    public function collection()
    {

        return $data = prch_itemwise_requs::select('item_name', 'm_quantity','quantity_unit','description')
        ->whereIn('id',explode(',',$this->values))->get();
        // return prch_itemwise_requs::select('item_name','m_quantity','quantity_unit','description')->where('id',5)->get();
        // return prch_itemwise_requs::where('prch_rfi_id',$this->ids)->get()([
        //     'item_name','m_quantity','quantity_unit','description'
        // ]);
        // return prch_itemwise_requs::with(relation:'category')->find($ids)->get();
        // return prch_itemwise_requs::all();
    }
}
