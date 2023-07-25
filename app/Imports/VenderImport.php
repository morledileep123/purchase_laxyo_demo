<?php

namespace App\Imports;

use App\Vendor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;
use App\item;
use App\item_category;
use App\Brand;
use App\Department;
use App\unitofmeasurement;
use App\itemconsumable;
use DB;

class VenderImport implements ToCollection,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   public function collection(Collection $data)
   {  
        //dd($data);
        if($data->count() > 0)
        {
           foreach($data->toArray() as $key => $value)
           {
                //dd($data);
                $insert_data[] = array(
                    'company'  => $value['company'],
                    'vendor_type'  => $value['vendor_type'],
                    'product'   => $value['product'],
                    'company_email'   => $value['company_email'],
                    'company_mobile'   => $value['company_mobile'],
                    'gstin'   => $value['gstin'],
                    'address1'   => $value['address1'],
                    'address2'   => $value['address2'],
                    'city'   => $value['city'],
                    'state'   => $value['state'],
                    'country'   => $value['country'],
                    'pin'   => $value['pin'],
                    'person_name'   => $value['person_name'],
                    'person_mobile'   => $value['person_mobile'],
                    'person_email'   => $value['person_email'],
                    'account_no'   => $value['account_no'],
                    'account_name'   => $value['account_name'],
                    'ifsc_code'   => $value['ifsc_code'],
                    'name_of_bank'  => $value['name_of_bank'],
                    
                );
                
            }

            if(!empty($insert_data))
            {
                DB::table('prch_vendors')->insert($insert_data);
            }
	    }
    }
}


?>
        
        <!-- //  return back()->with('success', 'Excel Data Imported successfully.');



     // dd($rows);
   		// foreach ($rows as $items) {
   		// 	 $category_id = item_category::where('name', $items['category_name'])->first();
   		// 	if(!empty($category_id)){
   		// 		$subcategory_id = Brand::where('name', $items['subcategory_name'])
   		// 											->where('category_id', $category_id->id)
   		// 											->first();
   		// 		if(!empty($subcategory_id)){
 				// 		$department = Department::where('name', $items['department'])->first();
 				// 		if(!empty($department)){
 				// 			$unit = unitofmeasurement::where('name', $items['units'])->first();
     //          $consume = itemconsumable::where('cat_name', $items['consumeable'])->first();
     //          // dd($unit);
 				// 			if(!empty($unit)){
 				// 				$item_name = item::where('title',$items['titles'])
 				// 												->where('category_id',$category_id->id)
 				// 												->where('brand',$subcategory_id->id)
 				// 												->where('department',$department->id)
 				// 												->where('unit_id',$unit->id)
     //                            ->where('cons_id',$consume->id)
 				// 												->first();
     //                            // dd($item_name);
 				// 				if(!empty($item_name)){

 				// 				}else{
 				// 				$ids = DB::select(DB::raw("SELECT nextval('prch_items_id_seq')"));
					//   			$id = $ids[0]->nextval+1;
					//         $cat = str_pad($category_id->id, 2, '0', STR_PAD_LEFT);
					//         $units = str_pad($unit->id, 2, '0', STR_PAD_LEFT);
					//         $item = str_pad($id, 4, '0', STR_PAD_LEFT);
					//         $barcode = $cat.$units.$item;
					//         $item_number = $barcode;
     //              //dd($item_number);
					//         $array = array(
					//         		'item_number'  =>  $item_number,
					//         		'title'  => $items['titles'],
     //                  'hsn_code'  => $items['hsn_code'],
					//         		'category_id'  => $category_id->id,
					//         		'brand'  => $subcategory_id->id,
					//         		'department'  => $department->id,
					//         		'unit_id'  => $unit->id,
     //                  'cons_id'  => $consume->id,
					//         		'description' => $items['description'],
     //                  'quantity' => $items['quantity']
					//         );
     //              //dd($array);
					//         item::create($array);  
 				// 				}
 				// 			}
 				// 		}
   		// 		}
   		// 	}else{
   		// 		$data = "Category Name is not exist";
   		// 	}
   		// }
 -->