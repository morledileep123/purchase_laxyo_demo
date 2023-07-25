<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use Helper;
use App\unitofmeasurement;
use App\GST_State_Code;
use App\VendorsItems;
use App\Imports\VenderItemsDescImport;
use App\itemconsumable;
use Response;
use Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VendorItemsController extends Controller
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
        $data = VendorsItems::latest()->get();
        return view('vendorItems.index',compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = GST_State_Code::all();
        $units = unitofmeasurement::get();        
        return view('vendorItems.create', compact('states','units'));
    }

    public function indexdemo()
    {
        $data = VendorsItems::orderBy('id', 'DESC')->paginate(10);
        return view('vendorItems.createImportShow',compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function importData(Request $request){
        
        $the_file = $request->file('uploaded_file');
        try{
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 2, $row_limit );
            $column_range = range( 'M', $column_limit );
            $startcount = 2;
            $data = array();
            foreach ( $row_range as $row ) {
                $data[] = [
                   'vendor_name' =>$sheet->getCell( 'A' . $row )->getValue(),
                   'address' => $sheet->getCell( 'B' . $row )->getValue(),
                   'material_code' => $sheet->getCell( 'C' . $row )->getValue(),
                   'material_desc' => $sheet->getCell( 'D' . $row )->getValue(),
                   'unit' => $sheet->getCell( 'E' . $row )->getValue(),
                   'state' =>$sheet->getCell( 'F' . $row )->getValue(),
                   'city' =>$sheet->getCell( 'G' . $row )->getValue(),
                   'country' =>$sheet->getCell( 'H' . $row )->getValue(),
                   'gst_no' =>$sheet->getCell( 'I' . $row )->getValue(),
                   'mobile_no' =>$sheet->getCell( 'J' . $row )->getValue(),
                   'bank_name' =>$sheet->getCell( 'K' . $row )->getValue(),
                   'account_no' =>$sheet->getCell( 'L' . $row )->getValue(),
                   'mail_id' =>$sheet->getCell( 'M' . $row )->getValue(),
                ];
                $startcount++;
            }
           DB::table('prch_vendors_items')->insert($data);
        } catch (Exception $e) {
           $error_code = $e->errorInfo[1];
           return back()->withErrors('There was a problem uploading the data!');
        }
       return back()->withSuccess('Great! Data has been successfully uploaded.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $request->validate([
            'vendor_name' => 'required',
            'material_desc' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',            
        ]);
            
        $data = new VendorsItems;
        $data->vendor_name = $request->vendor_name;
        $data->address = $request->address;
        $data->material_code = $request->material_code;
        $data->material_desc = $request->material_desc;
        $data->unit = $request->unit;
        $data->gst_no = $request->gst_no;
        $data->mobile_no = $request->mobile_no;
        $data->mail_id = $request->mail_id;
        $data->country = $request->country;
        $data->state = $request->state;
        $data->city = $request->city;
        $data->account_no = $request->account_no;
        $data->bank_name = $request->bank_name;

        $data->save();
   
        return redirect()->route('vendoritems.index')->with('success','Vendor and Items Description details added successfully.');
    }


    public function downloadVenderItemsDescSheetFormat(){
        //return "avhi";
        $path = storage_path('vendor-items-import-sheet.xlsx');
        return Response::download($path);
    }

    public function vendorItemsdesImport(Request $request)
    {
        $this->validate($request, ['excel_data' => 'required']);


        $the_file = $request->file('excel_data');
        try{
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 2, $row_limit );
            $column_range = range( 'M', $column_limit );
            $startcount = 2;
            $data = array();
            foreach ( $row_range as $row ) {
                $data[] = [
                   'vendor_name' =>$sheet->getCell( 'A' . $row )->getValue(),
                   'address' => $sheet->getCell( 'B' . $row )->getValue(),
                   'material_code' => $sheet->getCell( 'C' . $row )->getValue(),
                   'material_desc' => $sheet->getCell( 'D' . $row )->getValue(),
                   'unit' => $sheet->getCell( 'E' . $row )->getValue(),
                   'state' =>$sheet->getCell( 'F' . $row )->getValue(),
                   'city' =>$sheet->getCell( 'G' . $row )->getValue(),
                   'country' =>$sheet->getCell( 'H' . $row )->getValue(),
                   'gst_no' =>$sheet->getCell( 'I' . $row )->getValue(),
                   'mobile_no' =>$sheet->getCell( 'J' . $row )->getValue(),
                   'bank_name' =>$sheet->getCell( 'K' . $row )->getValue(),
                   'account_no' =>$sheet->getCell( 'L' . $row )->getValue(),
                   'mail_id' =>$sheet->getCell( 'M' . $row )->getValue(),
                ];
                $startcount++;
            }
           DB::table('prch_vendors_items')->insert($data);
        } catch (Exception $e) {
           $error_code = $e->errorInfo[1];
           return back()->withErrors('There was a problem uploading the data!');
        }
       return back()->withSuccess('Great! Data has been successfully uploaded.');



        

        // $file = $request->file('excel_data')->store('import');
        // $datas = Excel::import(new VenderItemsDescImport,request()->file('excel_data'));

        // if($datas){
        //   return redirect()->route('vendoritems.index')->with('success','Vendors Added successfully.');
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = VendorsItems::where('id',$id)->first();
        return view('vendorItems.show',compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = VendorsItems::where('id',$id)->first();
        $units = unitofmeasurement::get(); 
        return view('vendorItems.edit',compact('vendor','units'));
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
        // return $id;
        $data = array(
            'vendor_name' => $request->vendor_name,
            'address' => $request->address,
            'material_code' => $request->material_code,
            'material_desc' => $request->material_desc,
            'unit' => $request->unit,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'gst_no' => $request->gst_no,
            'account_no' => $request->account_no,
            'bank_name' => $request->bank_name,  
            'mobile_no' => $request->mobile_no,  
            'mail_id' => $request->mail_id,        
        );

        VendorsItems::where('id',$id)->update($data);
        
        return redirect()->route('vendoritems.index')->with('success','Details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = VendorsItems::find($id);
        $vendor->delete();
        return back()->with('success','Record deleted successfully');
    }
}
