<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company_site_name;
use App\SiteName;
use App\unitofmeasurement;
use App\prch_quotationwise_requs;
use App\Purchase_order;
use App\Purchase_order_detail;
use App\Vendor;
use App\Prch_Team;
use App\Send_quotation;
use App\Prch_Team_Person;
use App\ConsigneePersonDetails;
use App\Prch_Notifications;
use App\Send_quotation_Vendor_detail;
use App\Item_quotation_data;
use App\prch_itemwise_requs;
use App\Imports\QuotationImport;
use DB;
use Carbon\Carbon;
use PDF;
Use Mail;
use \App\Mail\SendQuotationToVendors;
use Storage;
use Auth;
use Validator;
use Maatwebsite\Excel\Facades\Excel;

class QuotationSendMailToVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user_id = Auth::user()->id;
        $site_id = Prch_Team_Person::where('user_id',$user_id)->pluck('team_id');
        $generate_data = Send_quotation::where('send_email',0)->whereIn('team_id',$site_id)->latest()->get();
        $send_po = Send_quotation::where('send_email',1)->whereIn('team_id',$site_id)->latest()->get();
        return view('Quotation_Vendor.index',compact('generate_data','send_po'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unitofmeasurement::get();
        $vendors = Vendor::all();
        $items_lists = ConsigneePersonDetails::pluck('name');
        $sites = SiteName::all();
        $items = prch_itemwise_requs::where('manager_status','=',1)->orderBy('id', 'DESC')->get()->unique('item_name');
        // $items = prch_itemwise_requs::where('manager_status','=',1)->distinct()->latest()->get();
        return view('Quotation_Vendor.create',compact('vendors','units','sites','items','items_lists'));
    }

    public function create_quotation_excel()
    {
        $units = unitofmeasurement::get();
        $vendors = Vendor::all();
        $sites = SiteName::all();
        $items = prch_quotationwise_requs::where('manager_status','=',1)->where('item_status','=',0)->pluck('item_name');
        return view('Quotation_Vendor.create_excel',compact('vendors','units','sites','items'));
    }

    public function vendor_quotation_excel()
    {
        $units = unitofmeasurement::get();
        $vendors = vendor::all();
        $sites = SiteName::all();
        $items = prch_quotationwise_requs::where('manager_status','=',1)->where('item_status','=',0)->pluck('item_name');
        return view('Quotation_Vendor.create_excel',compact('vendors','units','sites','items'));
    }

    public function item_details(Request $request)
    {
        $query = $request->get('query');
        $data = prch_itemwise_requs::where('item_name',$query)->get();
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
        $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
        $rfq_id = '#RFQ-'.substr($string, 0,7);

        $date = Carbon::parse();
        $date = $date->format('d-m-Y');

        $side_id = Prch_Team::where('side_id',$request->delivery_address_data)->first();

        $user_id = Auth::id();
        $sign = Company_site_name::where('id',$request->code_location)->first();

        $data = new Send_quotation;

        $data->rfq_id = $rfq_id;
        $data->date = $date;
        $data->delivery_address = $request->delivery_address;
        $data->delivery_date = $request->delivery_date;
        $data->person_name = $request->person_name;
        $data->subject = $request->subject;
        $data->user_id = $user_id;
        $data->full_address = $sign->full_address;
        $data->header_img = $sign->header_img;
        $data->footer_img = $sign->footer_img;
        $data->image = $sign->image;
        $data->watermark_img = $sign->watermark_img;
        $data->company_side = $request->code_location;
        $data->team_id = $side_id->id;

        $data->save();


        if ($request->file != null) {
             $item_id = $data->id;
            Excel::import(new QuotationImport($rfq_id,$item_id),$request->file);
        } else {
            $item_id = $data->id;
            $count = count($request->item_name);

            $i = 0;
            while($i < $count){

            $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
            $rfq_no = substr($string, 0,7);

                if($request->item_name[$i] !=''){
                  $newdata = array(
                      'item_id' => $item_id,
                      'rfq_id' => $rfq_id,
                      'rfq_no' => $rfq_no,                      
                      'item_name' => $request->item_name[$i],
                      'quantity' => $request->quantity[$i],
                      'quantity_unit' => $request->quantity_unit[$i],
                      'description' => $request->description[$i],
                      'remark' => $request->remark[$i],
                  );
                  
                Item_quotation_data::create($newdata);

                }       
                $i++;
            }

        }
    
        $count_vendors = count($request->vendore_company);

        $j = 0;
        while($j < $count_vendors){

        $vendor = Vendor::where('company',$request->vendore_company[$j])->first();  
        $vendor->company;
        $vendor->person_email;
        $vendor->address1;
        $vendor->state;
        $vendor->city;

        $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
            $rfq_no = substr($string, 0,7);

            if($request->vendore_company[$j] !=''){
              $newdata = array(
                  'item_id' => $item_id,
                  'rfq_no' => $rfq_no,                      
                  'rfq_id' => $rfq_id,
                  'company' => $vendor->company,
                  'person_email' => $vendor->person_email,
                  'address1' => $vendor->address1,
                  'state' => $vendor->state,
                  'city' => $vendor->city,
              );
              
            Send_quotation_Vendor_detail::create($newdata);

            }       
            $j++;
        }

        return redirect('vendor_quotation')->with('success','Quotation generater successfully.');
    }
    

    // public function download_pdf($id)
    // {
    //     $data = Send_quotation::where('id',$id)->first(); 
    //     $items = Item_quotation_data::where('item_id',$id)->get();       
    //     $vendors_data = Send_quotation_Vendor_detail::where('item_id',$id)->first();       
        
    //     // return view('Quotation_Vendor.download_purchase_order_receipt',compact('data','items','vendors_data'));
    //     $pdf = PDF::loadView('Quotation_Vendor.download_purchase_order_receipt',compact('data','items','vendors_data'));

    //     return $pdf->download('Quotation.pdf');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        $data = Send_quotation::where('id',$id)->first(); 
        $items = Item_quotation_data::where('item_id',$id)->get();       
        $vendors_data = Send_quotation_Vendor_detail::where('item_id',$id)->get();  

        return view('Quotation_Vendor.view_quotation',compact('data','items','vendors_data'));
    }

    public function Single_pdf_download($vendor_id,$item_id)
    {
        $data = Send_quotation::where('id',$item_id)->first(); 
        $items = Item_quotation_data::where('item_id',$item_id)->get();       
        $vendors_data = Send_quotation_Vendor_detail::where('id',$vendor_id)->first();       
        
        // return view('Quotation_Vendor.download_purchase_order_receipt',compact('data','items','vendors_data'));
        $pdf = PDF::loadView('Quotation_Vendor.download_purchase_order_receipt',compact('data','items','vendors_data'));

        return $pdf->download('Purchase.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = Send_quotation::where('id',$id)->first(); 
      $items = Item_quotation_data::where('item_id',$id)->get();       
      $vendors_data = Send_quotation_Vendor_detail::where('item_id',$id)->get();  

      return view('Quotation_Vendor.edit_quotation',compact('data','items','vendors_data'));
    }

    public function company_vendor_modal(Request $request)
    {
        $id = $request->post('id');
        $result = Send_quotation_Vendor_detail::find($id);
        return response()->json($result);
    }

    public function edit_vendor_quotation(Request $request)
    {
        $data = Send_quotation_Vendor_detail::find($request->id); 
        $data->company =  $request->company; 
        $data->person_email =  $request->person_email;  
        $data->address1 =  $request->address1;  
        $data->state =  $request->state;  
        $data->city =  $request->city; 
        $data->save();  

        return back()->with('success','Quotation vendor details updated successfully'); 

    }

    public function send_Quotation_mail(Request $request)
    {
        // return $request;
        $id = $request->id;
        $resever = $request->person_email;
        $send_cc = $request->send_cc;
        $send_bcc = $request->send_bcc;
        $subject = $request->subject;

        $count = count($request->person_email);
        // return $mail = Send_quotation::where('id',$request->id)->get();
        $vendors_data = Send_quotation_Vendor_detail::where('item_id',$request->id)->get(); 
        
        $details = array(
            'message' => strip_tags($request->message),
        );

        foreach($resever as $values){
            if ($send_cc == '') {
            \Mail::to($values)->bcc($send_bcc ?: [])->send(new SendQuotationToVendors($details,$id,$values));
            }else{
                foreach($request->send_cc as $mail_cc){
                \Mail::to($values)->cc($mail_cc)->bcc($send_bcc ?: [])->send(new SendQuotationToVendors($details,$id,$values));
                }
            }
        }

        return redirect('vendor_quotation')->with('success_mail', 'Quotation PDF send Email Successfully');
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
      // return $request;
       
      $data = Send_quotation::find($id); 
      $data->rfq_id =  $request->get('rfq_id'); 
      $data->date =  $request->get('date');  
      $data->delivery_address =  $request->get('delivery_address');  
      $data->delivery_date =  $request->get('delivery_date');  
      $data->subject =  $request->get('subject');  
      $data->person_name =  $request->get('person_name');  
      $data->full_address =  $request->get('full_address');  
      
      $count = count($request->item_name);
      for($x = 0; $x < $count; $x++) {
          $input = [
          'item_name' => $request->item_name[$x],
          'quantity' => $request->quantity[$x],
          'quantity_unit' => $request->quantity_unit[$x],
          'description' => $request->description[$x],
          'remark' => $request->remark[$x],              
          ];
     Item_quotation_data::where(['item_id'=>$id,'rfq_no' => $request->rfq_no[$x]])->update($input);
         
      }
      // $sign = Company_site_name::where('id',$request->sign)->pluck('image')->first(); 

      
     $data->save();  

      return redirect('vendor_quotation')->with('success','Quotation details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data=Send_quotation::find($request->quotation_id);
        $data->delete();
        return back()->with('delete', 'Quotation deleted Successfully');
    }

    public function vendor_form()
    {   
        return View('vendor_from');
    }
    
}
