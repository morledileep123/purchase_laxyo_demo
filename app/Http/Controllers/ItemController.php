<?php

namespace App\Http\Controllers;

use Validator;
use App\Department;
use App\Brand;
use App\item;
use App\unitofmeasurement;
use App\item_category;
use App\Sub_categories;
use App\Specifications;
use App\SiteName;
use App\Users;
use App\location;
use Helper;
use PDF;
use PDFs;
use DB;
use Excel;
use Illuminate\Http\Request;
use App\Imports\ItemsImport;
use App\Exports\ItemsExcelExport;
use App\Exports\ItemsExport;
use App\itemconsumable;
use File;
use Response;

class ItemController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        ini_set('memory_limit','-1');
        ini_set('max_execution_time',5000); 
        $category = item_category::get();
        $subcategory = Sub_categories::get();
        $specification = Specifications::get();
        $department = Department::get();
        $sites = SiteName::get(); 
        $units = unitofmeasurement::get();
        $items = DB::table('prch_items')->select('id','item_number','part_number','item_name','description','unit_id','rate','hsn_code','gst','category_id','sub_category_id','specification_name','brand_id','product_service_name','current_stock','min_stock_level','max_stock_level','department','location','consumption','consumable')->limit(1000)->get();
        $stock = DB::table("prch_items")->get()->sum("current_stock"); 
        return view('item.index', compact('category','subcategory','specification','department','items','sites','stock'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unitofmeasurement::get();
        $category = item_category::get();
        $department = Department::get();
        $sub_cat = Sub_categories::get();
        $brand = Brand::get();

        return view('item.create',compact('units','category','department','sub_cat','brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       //return $request;
        $data = $request->validate([
            'part_number' => 'required',            
            'item_name' => 'required',
            'quantity' => 'required',
            'unit_id' => 'required',
            'rate' => 'required',
            'hsn_code' => 'required',
            'gst' => 'required',
            'buy_sale_both' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'vendor_name' => 'required',
            'vendor_location' => 'required',
            'product_service_name' => 'required',
            'current_stock' => 'required',
            'min_stock_level' => 'required',
            'max_stock_level' => 'required',
            'dapartment' => 'required',
            'location' => 'required',
            'consumption' => 'required',
            'consumable' => 'required',
            // 'hsn_code' => 'required|max:9|min:4',
            // 'hsn_code' => 'required|max:9|min:4|unique:prch_items',
            
        ]);

        // $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
        // Adria Rae,brune
        // $order_id = 'ORD'.substr($string, 0,7);
        // $order->order_id = $order_id;

        // $categories = item_category::where('id', $request->category_id)->first();
        // $cat_id = $request->category_id;
        // $cat_skey = $categories->short_key;

        // $data_number = itemidentity($request->category_id,$request->brand);
        // $data['item_number'] = itemidentity($request->category_id,$request->brand);

        $ids = DB::select(DB::raw("SELECT nextval('prch_items_id_seq')"));
        $l_id = $ids[0]->nextval+1;

        $categories = item_category::where('id', $request->category_id)->first();
        $cat_id = $request->category_id;
        $cat_skey = $categories->short_key;

         $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');

         $order_id = $cat_skey.$cat_id.substr($string, 0,5);
         $data['item_number'] = $order_id;

        //$l_id = $lastitem->id;
       // return $insertdata = DB::select('call itemidentity(?,?,?)',array($l_id,$cat_id,$cat_skey));
         // return $data;
          $lastitem = item::create($data);
         

        return redirect()->route('item.index')->with('success','Item Added successfully.');

        // $user = new item;
        //  $user->item_number = $request->item_number;
        //  $user->part_number = $request->part_number;
        //  $user->title = $request->title;
        //  $user->unit_id = $request->unit_id;
        //  $user->rate = $request->rate;
        //  $user->hsn_code = $request->hsn_code;
        //  $user->gst = $request->gst;
        //  $user->category_id = $request->category_id;
        //  $user->sub_category_id = $request->sub_category_id;
        //  $user->brand = $request->brand;
        //  $user->vendor_name = $request->vendor_name;
        //  $user->vendor_location = $request->vendor_location;
        //  $user->product_service_name = $request->product_service_name;
        //  $user->current_stock = $request->current_stock;
        //  $user->min_stock_level = $request->min_stock_level;
        //  $user->max_stock_level = $request->max_stock_level;
        //  $user->dapartment = $request->dapartment;
         
        //  $user->location = $request->location;
        //  $user->consumption = $request->consumption;
        //  $user->consumerable = $request->consumerable;
        //  $user->save();


        
        // $lastitem = item::create($data);
        // $l_id = $lastitem->id;
        // $insertdata = DB::select('call itemcreate(?,?,?)',array($l_id,$cat_id,$cat_skey));
   
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(item $item)
    { 
        $units = unitofmeasurement::get();
        $category = item_category::get();
        $location = location::get();
        $brand = Brand::get();
        $department = Department::get();
        return view('item.show',compact('item','units','category','location','brand','department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(item $item)
    {
        $units = unitofmeasurement::get();
        $category = item_category::get();
        $brand = Brand::get();
        $department = Department::get();
        $itemconsumable = itemconsumable::get();
        return view('item.edit',compact('item','units','category','brand','department','itemconsumable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        return $request;
        $item = item::find($id); 
        // $categories = item_category::where('id', $request->category_id)->pluck('name');
        $units = unitofmeasurement::where('id', $request->unit_id)->first();
        $item->part_number =  $request->get('part_number');  
        $item->item_name = $request->get('item_name');  
        // $item->category_id = $categories;
        $item->unit_id = $units->name; 
        $item->hsn_code = $request->get('hsn_code'); 
        $item->description = $request->get('description'); 
        $item->rate = $request->get('rate'); 
        $item->gst = $request->get('gst');
        // return $item;
        $item->update();   
        return redirect()->back();
        // return redirect()->route('item.index')->with('success','Item details updated successfully');



    	// $id = $item['id'];
        // $request->validate([
        //     'title' => 'required|unique:prch_items,title,'.$id,
        //     'brand' => 'required',
        //     'department' => 'required',
        //     'unit_id' => 'required',
        //     'category_id' => 'required',
        //     'hsn_code' => 'required|max:9|min:9|unique:prch_items,'.$id,
        //     'cons_id' => 'required',
        // ]);
  
        // $item->update($request->all());
  
        // return redirect()->route('item.index')->with('success','Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(item $item)
    {
        $item->delete();
        return redirect()->route('item.index')->with('success','Item deleted successfully');
    }

   //  public function filter(Request $request)
   //  {
   //    $category = $request->category;
   //    $dept = $request->department;
   //    if(!empty($category)){
   //    	$items =item::with(['brand_name','department_name','category','unit'])->where('category_id', $category)->get(); 
   //    }
   //    if(!empty($dept)){
   //    	$items =item::with(['brand_name','department_name','category','unit'])->where('department', $dept)->get(); 
   //    }
   //    if(!empty($dept) && !empty($category)){
   //    	$items =item::with(['brand_name','department_name','category','unit'])->where('category_id', $category)->where('department', $dept)->get(); 
   //    }
			// return view('item.table',compact('items'));
   //  }
    public function itemcat(Request $request){

        return $cat = item::with('department_name')->where('category_id',$request->id)->get();
    }

    public function itemsfilter(Request $request){
           
           $items = item::where('category_id',$request->cat)->where('department',$request->dep)->get();
          return view('item.table',compact('items'));
    }

    public function export_pdf()
	  {

	    // $items = item::with(['brand_name','department_name','category','unit'])->get();
	    // $pdf = PDF::loadView('item.table', compact('items'));
	    // return $pdf->download('Items_'.date("d-M-Y").'.pdf');
        return view('item.multiple_item_create');
	  }
      public function abcderf()
      {
        $path = storage_path('item_data_sheet.xlsx');
        return Response::download($path);
      }

	  // public function downloadSheetFormat(){
   //      dd("iyuqdykeiydyi");
	  // 	$path = storage_path('123455 .xls');
	  // 	return Response::download($path);
	  // }

	public function excelImportItems(Request $request){
        $this->validate($request, ['excel_data' => 'required']);

        $file = $request->file('excel_data')->store('import');
        $datas = Excel::import(new ItemsImport,request()->file('excel_data'));
        //$datas = Excel::import(new VenderImport, $file);

        if($datas){
          return back()->with('success','Item Added successfully.');
       

     	//  $datas = Excel::import(new ItemsImport,request()->file('excel_data'));

     	// if($datas){
     	// 	return redirect()->route('item.index')->with('success','Item Added successfully.');
     	// }
        }
    }

      
    public function excelItemsExport() 
    {
        return Excel::download(new ItemsExcelExport, 'Items_'.date("d-M-Y").'.xls');
    }

}
