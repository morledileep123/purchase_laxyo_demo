<?php
namespace App\Imports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;
use App\VendorsItems;

use DB;

class VenderItemsDescImport implements ToCollection,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $data)
   { 
        if($data->count() > 0)
        {
            foreach($data->toArray() as $key => $value)
            {
                $insert_data[] = array(
                    'vendor_name' =>$value['vendor_name'],            
                    'address' => $value['address'],
                    'material_code' => $value['material_code'],
                    'material_desc' => $value['material_desc'],
                    'unit' => $value['unit'],
                    'state' => $value['state'],
                    'city' => $value['city'],
                    'country' => $value['country'],
                    'gst_no' => $value['gst_no'],
                    'mobile_no' => $value['mobile_no'],
                    'bank_name' => $value['bank_name'],
                    'account_no' => $value['account_no'],
                    'mail_id' => $value['mail_id'],
                );
            }
            if(!empty($insert_data))
            {
                DB::table('prch_vendors_items')->insert($insert_data);
            }
            
        }
    }
}

?>

