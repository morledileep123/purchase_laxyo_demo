<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;

use DB;

class QuotationImport implements ToCollection,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public $rfq_id;
    public $item_id;

    public function __construct($rfq_id,$item_id){
        $this->rfq_id = $rfq_id;
        $this->item_id = $item_id;
    }


    public function collection(Collection $collection)
    {
        if($collection->count() > 0)
        {
           foreach($collection->toArray() as $key => $value)
           {    
                $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
                $rfq_no = substr($string, 0,7);
                $insert_data[] = array(
                    'rfq_id' => $this->rfq_id,
                    'item_id' => $this->item_id,
                    'rfq_no' => $rfq_no,
                    'item_name' =>$value['name'],            
                    'quantity' => $value['qty'],
                    'quantity_unit' => $value['unit'],
                    'description' => $value['description'],
                );
            }
            if(!empty($insert_data))
            {
                DB::table('items_quotation_data')->insert($insert_data);
            }
        }
    }
}
