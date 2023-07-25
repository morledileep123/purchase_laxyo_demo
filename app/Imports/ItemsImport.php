<?php
namespace App\Imports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;
use App\item;
use App\item_category;
use App\Sub_categories;
use App\Brand;
use App\Department;
use App\unitofmeasurement;
use App\itemconsumable;
use DB;
class ItemsImport implements ToCollection,WithHeadingRow
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
            dd($data);
           foreach($data->toArray() as $key => $value)
           {
                dd($value);
                $ids = DB::select(DB::raw("SELECT nextval('prch_items_id_seq1')"));
                $l_id = $ids[0]->nextval+1;
                $categories = item_category::where('name', $value['category'])->first();
                
                $cat_id = $value['category'];
                $cat_skey = $categories->short_key;
               
                $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
                $order_id = $cat_skey.$cat_id.substr($string, 0,5);
                 
                $data['item_number'] = $order_id;
                $insert_data[] = array(
                    'item_number' => $order_id,
                    'part_number' =>$value['part_number'],            
                    'item_name' => $value['item_name'],
                    'unit_id' => $value['unit'],
                    'rate' => $value['rate'],
                    'hsn_code' => $value['hsn_code'],
                    'buy_sale_both' => $value['buysale'],
                    'gst' => $value['taxgst'],
                    'category_id' => $value['category'],
                    'brand_id' => $value['brand'],
                    'vendor_name' => $value['vendor_name'],
                    'vendor_location' => $value['vendor_location'],
                    'product_service_name' => $value['productservice'],
                    'current_stock' => $value['current_stock'],
                    'min_stock_level' => $value['min_stock_level'],
                    'max_stock_level' => $value['max_stock_level'],
                    'dapartment' => $value['department'],
                    'location' => $value['location'],
                    'consumption' => $value['consumption'],
                    'consumable' => $value['consumable'],  
                );
            }
            if(!empty($insert_data))
            {
                DB::table('prch_items')->insert($insert_data);
            }
        }
    }
}

?>

