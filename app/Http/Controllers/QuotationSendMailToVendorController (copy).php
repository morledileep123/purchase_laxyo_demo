<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company_site_name;
use App\SiteName;
use App\unitofmeasurement;
use App\prch_quotationwise_requs;
use App\Purchase_order;
use App\Purchase_order_detail;
use App\vendor;
use App\Send_quotation;
use App\Send_quotation_Vendor_detail;
use App\Item_quotation_data;
use DB;
use Carbon\Carbon;
use PDF;
Use Mail;
use \App\Mail\SendPOToVendors;
use Storage;
use Auth;

class QuotationSendMailToVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Quotation_Vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unitofmeasurement::get();
        $vendors = vendor::all();
        $sites = SiteName::all();
        $items = prch_quotationwise_requs::where('manager_status','=',1)->where('item_status','=',0)->pluck('item_name');
        return view('Quotation_Vendor.create',compact('vendors','units','sites','items'));
    }

    public function item_details(Request $request)
    {
        $query = $request->get('query');
        $data = prch_quotationwise_requs::where('item_name',$query)->get();
        $output = '';
        if(count($data) != null)
        {
          foreach($data as $row)
          {
            $output .= $row->quantity .'|'.$row->quantity_unit.'|'.$row->description;
            return response()->json($output);
          }
        }
        else
        {
          $output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
        }
        $output .= '';
        echo $output;
      
    }

    public function vendore_company_email(Request $request)
    {
        $data = $request;
        // $data=DB::table('prch_req_quotation')->where('item_name',$request->get('query'))->pluck('description');
        // $data = prch_quotationwise_requs::where('item_name',$request->get('query'))->get();
        
        return response()->json($data);
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
        $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
        $rfq_id = '#RFQ-'.substr($string, 0,7);

        $date = Carbon::parse();
        $date = $date->format('d-m-Y');

        $user_id = Auth::id();

        // $data = new Send_quotation;

        // $data->rfq_id = $rfq_id;
        // $data->date = $date;
        // $data->delivery_address = $request->delivery_address;
        // $data->delivery_date = $request->delivery_date;
        // $data->person_name = $request->person_name;
        // $data->subject = $request->subject;
        // $data->user_id = $user_id;
        // // $data->sign = $request->sign;

        // $data->save();
    
        // $item_id = $data->id;

        // $count = count($request->item_name);

        // $i = 0;
        // while($i < $count){

        // $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
        // $rfq_no = substr($string, 0,7);

        //     if($request->item_name[$i] !=''){
        //       $newdata = array(
        //           'item_id' => $item_id,
        //           'rfq_id' => $rfq_id,
        //           'rfq_no' => $rfq_no,                      
        //           'item_name' => $request->item_name[$i],
        //           'quantity' => $request->quantity[$i],
        //           'quantity_unit' => $request->quantity_unit[$i],
        //           'description' => $request->description[$i],
        //           'remark' => $request->remark[$i],
        //       );
              
        //     Item_quotation_data::create($newdata);

        //     }       
        //     $i++;
        // }

        // return back();
        $count = count($request->vendore_company);

        $i = 0;
        while($i < $count){

        $vendor = vendor::where('company',$request->vendore_company[$i])->first();  
        $vendor->company;
        $vendor->person_email;
        $vendor->address1;
        $vendor->state;
        $vendor->city;

        $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
            $rfq_no = substr($string, 0,7);

            if($request->item_name[$i] !=''){
              $newdata = array(
                  'item_id' => $item_id,
                  'rfq_no' => $rfq_no,                      
                  'rfq_id' => $rfq_id,
                  'company' => $vendor->company;,
                  'person_email' => $vendor->person_email,
                  'address1' => $vendor->address1,
                  'state' => $vendor->state,
                  'city' => $vendor->city,
              );
              
            Send_quotation_Vendor_detail::create($newdata);

            }       
            $i++;
        }




        $newdata = array(
              'company_name' => $request->company_name,
              'company_address' => $request->company_address,
              'phone_no' => $request->phone_no,
              'gst_no' => $request->gst_no,
              'delivery_address' => $request->delivery_address,
              'delivery_date' => $request->delivery_date,
              'rfq_id' => $rfq_id,
              'rfq_no' => $rfq_no,

        );
        //return $newdata;
        Send_quotation::create($newdata);

        $count = count($request->item_name); 
        $i=0;   
        while($i < $count){
            if($request->item_name[$i] !=''){
              
              $newitemsdata = array(
                  'item_name' => $request->item_name[$i],
                  'quantity' => $request->quantity[$i],
                  'quantity_unit' => $request->quantity_unit[$i],
                  'description' => $request->description[$i],
                  'remark' => $request->remark[$i],
                  'rfq_id' => $rfq_id,
                  'rfq_no' => $rfq_no,
              );

            Items_quotation::create($newitemsdata);

            }       
            $i++;
        }

        $count = count($request->vendore_company); 
        $j = 0;
          while($j < $count){
            if($request->vendore_company[$j] !=''){
            
              $idmain = DB::table('prch_vendors')->where('company', $request->vendore_company[$j])->first();
              $newdata = array(
                  'company_name' => $idmain->company,
                  'person_name' => $idmain->person_name,
                  'person_email' => $idmain->person_mobile,
                  'person_mobile' => $idmain->person_email,
              );

            Vendor_request::create($newdata);

            $person_email= $idmain->person_email;
            $company_name = $idmain->company;
                \Mail::to($person_email)->send(new SendMailToVendor($company_name,$person_email));
            }       
            $j++;
          }


        return redirect()->back()->with('success','Send Quotation to all vendors successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function vendor_form()
    {   
        return View('vendor_from');
    }
    
}
