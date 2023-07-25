<?php

namespace App\Http\Controllers;

use DB;
use Helper;
use App\Vendor;
use App\Vendormain;
use App\item;
use App\GST_State_Code;
use App\Subcategories;
use App\item_category;
use Illuminate\Http\Request;
use App\Imports\VenderImport;
use App\itemconsumable;
use Response;
use Excel;

class VendorController extends Controller
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
        $vendors = Vendor::latest()->get();
        return view('vendor.index',compact('vendors'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $states = GST_State_Code::all();
        $items = item::all();
        $gst = DB::table('prch_gst_state_codes')->get();
        $subcategory = Subcategories::all();
        $category = item_category::all();
        return view('vendor.create', compact('items','category','subcategory','gst','states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        // return $request;
        $request->validate([
            'company' => 'required',
            'company_email' => 'required',
            'address1' => 'required',
            'city' => 'required',
            'pin' => 'required',            
        ]);
            
        $data = new Vendor;
        $data->company = $request->company;
        $data->vendor_type = $request->vendor_type;
        $data->product = $request->product;
        $data->company_email = $request->company_email;
        $data->company_mobile = $request->company_mobile;
        $data->gstin = $request->gstin;
        $data->address1 = $request->address1;
        $data->address2 = $request->address2;
        $data->city = $request->city;
        $data->state = $request->state;
        $data->country = $request->country;
        $data->pin = $request->pin;
        $data->person_name = $request->person_name;
        $data->person_mobile = $request->person_mobile;
        $data->person_email = $request->person_email;
        $data->account_no = $request->account_no;
        $data->account_name = $request->account_name;
        $data->ifsc_code = $request->ifsc_code;
        $data->name_of_bank = $request->name_of_bank;

        $data->save();
   
        return redirect()->route('vendor.index')->with('success','Vendor Added successfully.');
    }


    public function downloadVenderSheetFormat(){
        //return "avhi";
        $path = storage_path('vendor-import-sheet.xlsx');
        return Response::download($path);
    }

    public function vendorexcel(Request $request)
    {

        $this->validate($request, ['excel_data' => 'required']);

        $file = $request->file('excel_data')->store('import');
        $datas = Excel::import(new VenderImport,request()->file('excel_data'));
        //$datas = Excel::import(new VenderImport, $file);

        if($datas){
          return back()->with('success','Vendors Added successfully.');
          // return redirect()->route('item.index')->with('success','Item Added successfully.');
        }



        // $path = $request->file('excel_data')->getRealPath();

        // $data = Excel::load($path)->get();

        // if($data->count() > 0)
        // {
        //    foreach($data->toArray() as $key => $value)
        //    {
        //        foreach($value as $row)
        //        {
        //             $insert_data[] = array(
        //                 'vendor_type'  => $row['vendor_type'],
        //                 'firm_type'   => $row['firm_type'],
        //                 'firm_name'   => $row['firm_name'],
        //                 'email'   => $row['email'],
        //                 'mobile'   => $row['mobile'],
        //                 'address'   => $row['address'],
        //                 'city'   => $row['city'],
        //                 'postal_code'   => $row['postal_code'],
        //                 'country'   => $row['country'],
        //                 'state'   => $row['state'],
        //                 'name'   => $row['name'],
        //                 'phone'   => $row['phone'],
        //                 'fax'   => $row['fax'],
        //                 'website'   => $row['website'],
        //                 'photo'   => $row['photo'],
        //                 'pan_no'   => $row['pan_no'],
        //                 'aadhar_no'   => $row['aadhar_no'],
        //                 'gst_number'   => $row['gst_number'],
        //                 'annual_turnover'   => $row['annual_turnover'],
        //                 'reference_name1'   => $row['reference_name1'],
        //                 'reference_name2'   => $row['reference_name2'],
        //             );
        //         }
        //     }

        //     if(!empty($insert_data))
        //     {
        //         DB::table('prch_vendors')->insert($insert_data);
        //     }
        // }
        //  return back()->with('success', 'Excel Data Imported successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(vendor $vendor)
    {
        // $item_id = json_decode($vendor->item_id);
        // if(!empty($item_id)) {
        //  $items = item::whereIn('id',$item_id)->get();
        // }else{
        //  $items = array();
        // }
        $vendor = Vendor::where('id',$vendor->id)->first();
        return view('vendor.show',compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(vendor $vendor)
    {
        // $items = item::all();
        // $gst = DB::table('prch_gst_state_codes')->get();
        $vendor = Vendor::where('id',$vendor->id)->first();
        return view('vendor.edit',compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // $vendor = Vendor::where('id', $id)->firstOrFail();
        $data = array(
            'company' => $request->company,
            'vendor_type' => $request->vendor_type,
            'product' => $request->product,
            'company_email' => $request->company_email,
            'company_mobile' => $request->company_mobile,
            'gstin' => $request->gstin,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pin' => $request->pin,
            'person_name' => $request->person_name,
            'person_mobile' => $request->person_mobile,
            'person_email' => $request->person_email,
            'account_no' => $request->account_no,
            'account_name' => $request->account_name,
            'ifsc_code' => $request->ifsc_code,
            'name_of_bank' => $request->name_of_bank,
        );
        //return $data;
        Vendor::where('id', $id)->update($data);
        //$vendor->update($data);
  
        return redirect()->route('vendor.index')->with('success','Vendors details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();
        return back()->with('success','Vendors record deleted successfully');
    }
}
