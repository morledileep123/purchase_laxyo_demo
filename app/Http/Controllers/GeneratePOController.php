<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;

use Illuminate\Http\Request;
use App\Company_site_name;
use App\SiteName;
use App\unitofmeasurement;
use App\prch_quotationwise_requs;
use App\Purchase_order;
use App\Purchase_order_detail;
use App\Prch_Team_Person;
use App\Prch_Team;
use App\prch_itemwise_requs;
use App\prch_item_request_detail;
use App\ConsigneePersonDetails;
use App\Vendor;
use DB;
use App\User;
use Auth;
use Carbon\Carbon;
use PDF;
use App\Notifications\AdminRequestNotification;
use App\Prch_Notifications;
Use Mail;
use \App\Mail\SendPOToVendors;
use Storage;

class GeneratePOController extends Controller
{
    public function index()
    { 
        $user_id = Auth::user()->id;
        $site_id = Prch_Team_Person::where('user_id',$user_id)->pluck('team_id');
        // $generate_po = Purchase_order_detail::with('prch_order')->where('item_id',10)->get();
        $generate_po = Purchase_order::with('prch_order')->where([['send_email',0],['super_admin_status',0]])->whereIn('team_id',$site_id)->latest()->get();
        $approve_po = Purchase_order::with('prch_items')->where([['send_email',0],['super_admin_status','!=',0]])->whereIn('team_id',$site_id)->latest()->get();
        $send_po = Purchase_order::where('send_email',1)->whereIn('team_id',$site_id)->latest()->get();
        $items_name = DB::table('prch_order_items_detail')->select("item_id as id",DB::raw("string_agg(invoice_product,',') as item"))->groupBy('item_id')->get();

        return view('Generate_Purchase_Order.index',compact('generate_po','approve_po','send_po','items_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::all();
        $user_id = Auth::user()->id;
        $site_id = Prch_Team_Person::where('user_id',$user_id)->pluck('team_id');
        $sites = SiteName::all();
        $units = unitofmeasurement::get();
        $items_lists = ConsigneePersonDetails::pluck('name');
        $items = prch_itemwise_requs::where('manager_status','=',1)->pluck('item_name');
          
        return view('Generate_Purchase_Order.create',compact('vendors','sites','units','items','items_lists'));
    }

    public function test()
    {
        $vendors = vendor::all();
        $sites = SiteName::all();
        $units = unitofmeasurement::get();
        $items = prch_quotationwise_requs::where('manager_status','=',1)->where('item_status','=',0)->pluck('item_name');
          
        return view('Generate_Purchase_Order.testGO',compact('vendors','sites','units','items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'delivery_address' => 'required',
        //     'grand_total' => 'required',
        // ]);
        $this->validate($request,[
            'delivery_address'=>'required',
        ]);

        $user_id = Auth::user()->id;

        $sign = Company_site_name::where('id',$request->code_location)->first();
        $code_loc = $sign->code_location;
        $first_code = $sign->first_code_company;

        $full_date_info= Carbon::now();

        $full_date = $full_date_info->day;   
          
        $today = Purchase_order::whereDate('created_at', Carbon::today())->first();
        // $lastest_code = "LEL/IND/2022/08/MON/PO0056";
        $lastest_code = DB::table('prch_purchase_order')->orderBy('created_at', 'desc')->pluck('code')->first();
        $last_date = substr($lastest_code, -2);

        $side_id = Prch_Team::where('side_id',$request->delivery_address_id)->first();

        $year= date("Y"); 
        $month= $full_date_info->day;
        $month= date("M"); 

        if($full_date == 1){ 
            if ($today == '') {
               $next = sprintf("%02d", 1);
               $code =  $first_code.'/'.$code_loc.'/'.$year.'/'.$month.'/'.$next;
            } else {
               $next = $last_date + 1;
               $next = sprintf("%02d", $next);
               $code =  $first_code.'/'.$code_loc.'/'.$year.'/'.$month.'/'.$next;
            }
        }else{
            $next = $last_date + 1;
            $next = sprintf("%02d", $next);
            $code =  $first_code.'/'.$code_loc.'/'.$year.'/'.$month.'/'.$next;
        }        

        if ($request->vender_detail == null) {
            $sign = Company_name::where('id',$request->code_location)->first();
            
            $po_data = new Purchase_order;

            $po_data->vender_detail = $request->vender_detail_infor;
            $po_data->subject = $request->subject;
            $po_data->subject_contents = $request->subject_contents;
            $po_data->delivery_address = $request->delivery_address;
            $po_data->delivery_date = $request->delivery_date;
            $po_data->perosn_name = $request->perosn_name;
            $po_data->quotation_no = $request->quotation_no;
            $po_data->terms1 = $request->terms1;
            $po_data->terms2 = $request->terms2;
            $po_data->terms3 = $request->terms3;
            $po_data->invoice_subtotal = $request->invoice_subtotal;
            $po_data->invoice_discount = $request->invoice_discount;
            $po_data->invoice_total = $request->invoice_total;
            $po_data->grand_total = $request->grand_total;
            $po_data->amount_rupees = $request->amount_rupees;
            $po_data->guarantee = $request->guarantee;
            $po_data->full_address = $sign->full_address;
            $po_data->header_img = $sign->header_img;
            $po_data->footer_img = $sign->footer_img;
            $po_data->image = $sign->image;
            $po_data->watermark_img = $sign->watermark_img;
            $po_data->first_code = $first_code;
            $po_data->code_location = $request->code_location;
            $po_data->charges_head = $request->charges_head;
            $po_data->charges = $request->charges;
            $po_data->team_id = $side_id->id;
            $po_data->user_id = $user_id;

            $po_data->counter = count($request->invoice_product);

            $po_data->invoice_product = json_encode($request->invoice_product);
            
            $po_datas['invoice_product'] = $request->invoice_product;
            $po_datas['description'] = $request->description;
            $po_datas['product_qty'] = $request->product_qty;
            $po_datas['quantity_unit'] = $request->quantity_unit;
            $po_datas['product_price'] = $request->product_price;
            $po_datas['product_tax'] = $request->product_tax;
            $po_datas['product_discount'] = $request->product_discount;
            $po_datas['total'] = $request->total;
            $po_datas['taxa'] = $request->taxa;
            $po_datas['disca'] = $request->disca;
            $po_datas['product_subtotal'] = $request->product_subtotal;
            $po_datas['invoice_product_sub'] = $request->invoice_product_sub;
            $po_datas['comment'] = $request->comment;

            $po_data->code = $code;
            $po_data->vender_email = $request->vender_email;

            $date = Carbon::parse();
            $po_data->date = $date->format('d-m-Y');

            $po_data->counter = count($request->invoice_product);

            $po_data_s['vendor_details_company'] = $request->vender_detail_infor;
                
            $pdf = PDF::loadView('Generate_Purchase_Order.purchase_order_receipt',compact('po_data','po_datas'));
            
            $to_email = $request->vender_email;

            if($request->hasfile('quotation_excel_sheet')) {
                $file = $request->file('quotation_excel_sheet');
                $filename = 'assets/Quotation_Excel_sheet/'.time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/assets/Quotation_Excel_sheet',$filename);
                $po_data->quotation_excel_sheet = $filename;
            }
            
            $vendor_email = $request->vender_email;         
            
            $po_data->save();  
            $item_id = $po_data->id;

            $i = 0;
            while($i < $po_data->counter){

            $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
                $order_id = 'Order'.substr($string, 0,7);

                if($request->invoice_product[$i] !=''){
                  $newdata = array(
                      'order_id' => $order_id,                      
                      'item_id' => $item_id,
                      'invoice_product' => $request->invoice_product[$i],
                      'description' => $request->description[$i],
                      'product_qty' => $request->product_qty[$i],
                      'quantity_unit' => $request->quantity_unit[$i],
                      'product_price' => $request->product_price[$i],
                      'product_tax' => $request->product_tax[$i],
                      'product_discount' => $request->product_discount[$i],
                      'total' => $request->total[$i],
                      'taxa' => $request->taxa[$i],
                      'disca' => $request->disca[$i],
                      'product_subtotal' => $request->product_subtotal[$i],
                      'comment' => $request->comment[$i],
                  );
                  
                Purchase_order_detail::create($newdata);

                }       
                $i++;
            } 

            return redirect('generate_po')->with('success', 'Purchase Order send PDF Successfully');

         } else {
            $vendor_details_company = Vendor::where('id',$request->vender_details)->pluck('company')->first();
            $vendor_details_company_address = Vendor::where('id',$request->vender_details)->pluck('address1')->first();
            $vendor_details_city = Vendor::where('id',$request->vender_details)->pluck('city')->first();
            $vendor_details_pin = Vendor::where('id',$request->vender_details)->pluck('pin')->first();
            $vendor_details_state = Vendor::where('id',$request->vender_details)->pluck('state')->first();
            $vendor_details_company_gstin = Vendor::where('id',$request->vender_details)->pluck('gstin')->first();
            $vendor_details_person_email = Vendor::where('id',$request->vender_details)->pluck('person_email')->first();

            $sign = Company_site_name::where('id',$request->code_location)->first();
             
            $po_data = new Purchase_order;

            $po_data->vendor_details_company = $vendor_details_company;
            $po_data->vendor_details_company_email = $vendor_details_company_email;
            $po_data->vendor_details_company_mobile = $vendor_details_company_mobile;
            $po_data->vendor_details_city = $vendor_details_city;
            $po_data->vendor_details_state = $vendor_details_state;
            $po_data->vendor_details_pin = $vendor_details_pin;
            $po_data->vendor_details_person_email = $vendor_details_person_email;
            $po_data->subject = $request->subject;
            $po_data->subject_contents = $request->subject_contents;
            $po_data->delivery_address = $request->delivery_address;
            $po_data->perosn_name = $request->perosn_name;
            $po_data->quotation_no = $request->quotation_no;
            $po_data->delivery_date = $request->delivery_date;
            $po_data->terms1 = $request->terms1;
            $po_data->terms2 = $request->terms2;
            $po_data->terms3 = $request->terms3;
            $po_data->invoice_subtotal = $request->invoice_subtotal;
            $po_data->invoice_discount = $request->invoice_discount;
            $po_data->invoice_total = $request->invoice_total;
            $po_data->grand_total = $request->grand_total;
            $po_data->amount_rupees = $request->amount_rupees;
            $po_data->guarantee = $request->guarantee;
            $po_data->full_address = $sign->full_address;
            $po_data->header_img = $sign->header_img;
            $po_data->footer_img = $sign->footer_img;
            $po_data->image = $sign->image;
            $po_data->watermark_img = $sign->watermark_img;
            $po_data->first_code = $first_code;
            $po_data->code = $code;
            $po_data->code_location = $request->code_location;
            $po_data->charges_head = $request->charges_head;
            $po_data->charges = $request->charges;
            $po_data->team_id = $side_id->id;
            $po_data->user_id = $user_id;

            if($request->hasfile('quotation_excel_sheet')) {
                $file = $request->file('quotation_excel_sheet');
                $filename = 'assets/Quotation_Excel_sheet/'.time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/assets/Quotation_Excel_sheet',$filename);
                $po_data->quotation_excel_sheet = $filename;
            }

            $po_data->counter = count($request->invoice_product);

            $po_data->invoice_product = json_encode($request->invoice_product);

            $po_datas['invoice_product'] = $request->invoice_product;
            $po_datas['description'] = $request->description;
            $po_datas['product_qty'] = $request->product_qty;
            $po_datas['quantity_unit'] = $request->quantity_unit;
            $po_datas['product_price'] = $request->product_price;
            $po_datas['product_tax'] = $request->product_tax;
            $po_datas['product_discount'] = $request->product_discount;
            $po_datas['total'] = $request->total;
            $po_datas['taxa'] = $request->taxa;
            $po_datas['disca'] = $request->disca;
            $po_datas['product_subtotal'] = $request->product_subtotal;
            $po_datas['invoice_product_sub'] = $request->invoice_product_sub;
            $po_datas['comment'] = $request->comment;

            $date = Carbon::parse();
            $po_data->date = $date->format('d-m-Y');

            $po_data_s['vendor_details_company'] = $vendor_details_company;

            //return view('Generate_Purchase_Order.purchase_order_receipt',compact('po_data','po_datas'));
            $pdf = PDF::loadView('Generate_Purchase_Order.purchase_order_receipt',compact('po_data','po_datas'));

            $pdf->download('Purchase.pdf');
            
            $po_data->save();
            $item_id = $po_data->id;

            $i = 0;
            
            while($i < $po_data->counter){
                $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
                $order_id = 'Order'.substr($string, 0,7);
                if($request->invoice_product[$i] !=''){
                  $newdata = array(
                      'order_id' =>$order_id,
                      'item_id' => $item_id,
                      'invoice_product' => $request->invoice_product[$i],
                      'description' => $request->description[$i],
                      'product_qty' => $request->product_qty[$i],
                      'quantity_unit' => $request->quantity_unit[$i],
                      'product_price' => $request->product_price[$i],
                      'product_tax' => $request->product_tax[$i],
                      'product_discount' => $request->product_discount[$i],
                      'total' => $request->total[$i],
                      'taxa' => $request->taxa[$i],
                      'disca' => $request->disca[$i],
                      'product_subtotal' => $request->product_subtotal[$i],
                      'comment' => $request->comment[$i],
                  );
                  
                Purchase_order_detail::create($newdata);

                }       
                $i++;
            } 

            // $site_id = Prch_Team_Person::where(['team_id'=>$side_id->id,'role'=>21])->pluck('user_id');
            // $user_id = Auth::user()->id;
            // foreach($site_id as $mail){
            //     $usersmail = User::find($mail)->get(); 
            //     Notification::send($usersmail, New AdminRequestNotification);
            //     $notifi_data = new Prch_Notifications;
            //     $notifi_data->notifiable_id = $user_id;
            //     $notifi_data->notifiable_to = $mail->id;
            //     $notifi_data->data = 'Admin Send Purchase Order Request';
            //     $notifi_data->page_link = 'http://purchase.laxyo.org/purchase';
            //     $notifi_data->save();
            // }         

            return redirect('generate_po')->with('success', 'Purchase Order Generate and Send Successfully');
        }
    }

    public function send_mail(Request $request)
    {
        $id = $request->id;
        $resever = 'sourabh.joshi.sdbg@gmail.com';
        $send_cc = $request->send_cc;
        $send_bcc = $request->send_bcc;
        $subject = $request->subject;
        
        $details = array(
            'message' => strip_tags($request->message),
        );
        // Mail::send('Generate_Purchase_Order.pomail',$details,function($message)use($details,$pdf,$resever,$send_bcc,$send_cc,$subject) {
        //         $message->to($resever)
        //                 ->cc($send_cc ?: [])
        //                 ->bcc($send_bcc ?: [])
        //                 ->subject($subject)
        //                 ->attachData($pdf->output(), "PurchaseOrder.pdf");
        //     });

        \Mail::to($resever)->cc($send_cc ?: [])->bcc($send_bcc ?: [])->send(new SendPOToVendors($details,$id));
        return redirect('generate_po')->with('success_mail', 'Purchase Order PDF send Email Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Purchase_order::where('id',$id)->first(); 
        $items = Purchase_order_detail::where('item_id',$id)->get(); 

        return view('Generate_Purchase_Order.view_purchase_order_receipt',compact('data','items'));
    }

    public function send_purchase_order($id)
    {
        $data = Purchase_order::where('id',$id)->first(); 
        $items = Purchase_order_detail::where('item_id',$id)->get(); 

        return view('Generate_Purchase_Order.send_purchase_order_receipt',compact('data','items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Purchase_order::where('id',$id)->first(); 
        $items = Purchase_order_detail::where('item_id',$id)->get(); 

        return view('Generate_Purchase_Order.edit_purchase_order_receipt',compact('data','items'));
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
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {        
        $data=Purchase_order::find($request->po_id);
        $data->delete();
        return back()->with('delete', 'Purchase Order deleted Successfully');
    }


    public function company_full_detail(Request $request)
    {
        $a = $request->post('a');
        $data = Company_site_name::where('id',$a)->pluck('full_address');
        return response()->json($data);
    }

    public function send_vendor(Request $request)
    {
        $svendor = $request->post('query');
        $svendors = Vendor::where('id',$svendor)->get();

        $output = '';
        foreach($svendors as $row)
{
$output .= 'Company Name : '.$row->company .' 
Address 1 : '.$row->address1.'
Address 2 : '.$row->address2.'
Person Email : '.$row->company_email.'
Person Mobile : '.$row->company_mobile.'
';

}
        $output .= '';

        echo $output;

        // $userData = $svendors;
        // echo json_encode($svendors);

    }


    public function retrive_delivery_location(Request $request)
    {

        $location = $request->post('query');
        $locations = SiteName::where('id',$location)->pluck('site_name_detail');

//         $output = '';
//         foreach($locations as $row)
// {
// $output .= 'Company Name : '.$row->name .'';

// }
//         $output .= '';

//         echo $output;

        return response()->json($locations);
        // echo json_encode($locations);
    }

    public function item_details(Request $request)
    {
        if($request->get('query'))
      {
        $query = $request->get('query');
        $data = prch_itemwise_requs::where('item_name', 'ILIKE', "%{$query}%")->pluck('description');

        return response()->json($data);
      }
    }

    public function company_sign_pics(Request $request)
    {
        $query = $request->get('sign');
        $data = Company_site_name::where('id',$query)->pluck('images');
        return response()->json($data);
    }

    public function show_po()
    {
      return view('Generate_Purchase_Order.purchase_order_receipt');  
    }

    public function download_pdf($id)
    {
        $data = Purchase_order::where('id',$id)->first(); 
        $items = Purchase_order_detail::where('item_id',$id)->get();       
        
        //return view('Generate_Purchase_Order.download_purchase_order_receipt',compact('data','items'));
        $pdf = PDF::loadView('Generate_Purchase_Order.download_purchase_order_receipt',compact('data','items'));

        return $pdf->download('Purchase.pdf');
    }

    public function company_sign_pics_update(Request $request)
    {
        $query = $request->get('sign');
        $data = Company_site_name::where('id',$query)->pluck('images');
        return response()->json($data);
    }

    public function update_purchase_order(Request $request, $id)
    {
        $data = Purchase_order::find($id); 
        $data->code =  $request->get('code'); 
        $data->date =  $request->get('date');  
        $data->vender_detail =  $request->get('vender_detail');  
        $data->vendor_details_company =  $request->get('vendor_details_company');  
        $data->vendor_details_company_email =  $request->get('vendor_details_company_email');  
        $data->vendor_details_company_mobile =  $request->get('vendor_details_company_mobile');  
        $data->vendor_details_city =  $request->get('vendor_details_city');  
        $data->vendor_details_state =  $request->get('vendor_details_state');  
        $data->vendor_details_pin =  $request->get('vendor_details_pin');  
        $data->vendor_details_person_email =  $request->get('vendor_details_person_email');  
        $data->subject =  $request->get('subject');  
        $data->quotation_no =  $request->get('quotation_no');  
        $data->subject_contents =  $request->get('subject_contents'); 
      
        $count = count($request->invoice_product);
        for($x = 0; $x < $count; $x++) {
            $input = [
            'invoice_product' => $request->invoice_product[$x],
            'description' => $request->description[$x],
            'quantity_unit' => $request->quantity_unit[$x],
            'comment' => $request->comment[$x],
                
        ];
        Purchase_order_detail::where(['item_id'=>$id,'order_id' => $request->order_id[$x]])->update($input);  
         
        }

        $data->terms1 =  $request->get('terms1'); 
        $data->terms2 =  $request->get('terms2'); 
        $data->terms3 =  $request->get('terms3'); 
        $data->guarantee =  $request->get('guarantee'); 
        $data->invoice_subtotal =  $request->get('invoice_subtotal'); 
        $data->invoice_discount =  $request->get('invoice_discount');
        $data->grand_total =  $request->get('grand_total');
        $data->amount_rupees =  $request->get('amount_rupees');
        $data->delivery_date =  $request->get('delivery_date');
        $data->delivery_address =  $request->get('delivery_address');
        $data->perosn_name =  $request->get('perosn_name');
        $data->sign =  $request->get('sign');
        // dd($data);
        $data->save();  
        return redirect('generate_po')->with('success','purchase order details updated successfully');
    }

    
}
