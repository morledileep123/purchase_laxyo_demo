<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company_site_name;
use App\SiteName;
use App\unitofmeasurement;
use App\prch_quotationwise_requs;
use App\Purchase_order;
use App\vendor;
use \App\Mail\SendMailForPurchasOrder;
use DB;
use Carbon\Carbon;
use PDF;
Use Mail;
use Storage;

class GeneratePOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Purchase_order::latest()->paginate(10);
        return view('Generate_Purchase_Order.purchase_order_list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::all();
        $sites = SiteName::all();
        $units = unitofmeasurement::get();
        $items = prch_quotationwise_requs::where('manager_status','=',1)->where('item_status','=',0)->pluck('item_name');
          
        return view('Generate_Purchase_Order.generate_po',compact('vendors','sites','units','items'));
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
        // $this->validate($request, [
        //     'delivery_address' => 'required',
        //     'grand_total' => 'required',
        // ]);



        $full_date_info= Carbon::now();
        $full_date = $full_date_info->day;    

        // $lastest_code = "LEL/IND/2022/08/MON/PO0056";
         $lastest_code = DB::table('prch_purchase_order')->orderBy('code', 'desc')->pluck('code')->first();
         $last_date = substr($lastest_code, -2);

        $year= date("Y"); 
        $month= date("M"); 
        $day= date("D"); 

        $first_code = "LEL";

        if($full_date == 1){            
            $code =  $first_code.'/'.$request->code_location.'/'.$year.'/'.$month.'/'."1";
        }else{
            $next = $last_date + 1;
            $code =  $first_code.'/'.$request->code_location.'/'.$year.'/'.$month.'/'.$next;
        }
         

        if ($request->vender_detail == null) {
            $sign = Company_site_name::where('id',$request->sign)->pluck('image')->first();
            
            $po_data = new Purchase_order;

            $po_data->vender_detail = $request->vender_detail_infor;
            $po_data->subject = $request->subject;
            $po_data->subject_contents = $request->subject_contents;
            $po_data->delivery_address = $request->delivery_address;
            $po_data->delivery_date = $request->delivery_date;
            $po_data->perosn_name = $request->perosn_name;
            $po_data->quotation_noquotation_no = $request->quotation_noquotation_no;
            $po_data->terms1 = $request->terms1;
            $po_data->terms2 = $request->terms2;
            $po_data->terms3 = $request->terms3;
            $po_data->invoice_subtotal = $request->invoice_subtotal;
            $po_data->invoice_discount = $request->invoice_discount;
            $po_data->invoice_total = $request->invoice_total;
            $po_data->grand_total = $request->grand_total;
            $po_data->amount_rupees = $request->amount_rupees;
            $po_data->guarantee = $request->guarantee;
            $po_data->sign = $sign;
            
            $po_datas['invoice_product'] = $request->invoice_product;
            $po_datas['description'] = $request->description;
            $po_datas['invoice_product_qty'] = $request->invoice_product_qty;
            $po_datas['quantity_unit'] = $request->quantity_unit;
            $po_datas['invoice_product_price'] = $request->invoice_product_price;
            $po_datas['invoice_product_tax'] = $request->invoice_product_tax;
            $po_datas['total'] = $request->total;
            $po_datas['invoice_product_sub'] = $request->invoice_product_sub;
            $po_datas['comment'] = $request->comment;

            $po_data->code = $code;
            $po_data->vender_email = $request->vender_email;

            $date = Carbon::parse();
            $po_data->date = $date->format('d-m-Y');

            $po_data->count = count($request->invoice_product);

            $po_data_s['vendor_details_company'] = $request->vender_detail_infor;
                
            $pdf = PDF::loadView('Generate_Purchase_Order.purchase_order_receipt',compact('po_data','po_datas'));
            
            $to_email = $request->vender_email;
            
            $vendor_email = $request->vender_email; 
            Mail::send('Generate_Purchase_Order.pomail', $po_data_s, function($message)use($po_data_s,$pdf,$to_email) {
                $message->to($to_email)
                        ->subject('Purchase Order Details')
                        ->attachData($pdf->output(), "PurchaseOrder.pdf");
            });         
            
            $po_data->save();  

            return redirect('generate_po')->with('success', 'Purchase Order send PDF Successfully');

         } else {
            $vendor_details_company = $vendors = vendor::where('id',$request->vender_details)->pluck('company')->first();
            $vendor_details_company_email = $vendors = vendor::where('id',$request->vender_details)->pluck('company_email')->first();
            $vendor_details_company_mobile = $vendors = vendor::where('id',$request->vender_details)->pluck('company_mobile')->first();
            $vendor_details_city = $vendors = vendor::where('id',$request->vender_details)->pluck('city')->first();
            $vendor_details_state = $vendors = vendor::where('id',$request->vender_details)->pluck('state')->first();
            $vendor_details_pin = $vendors = vendor::where('id',$request->vender_details)->pluck('pin')->first();
            $vendor_details_person_email = $vendors = vendor::where('id',$request->vender_details)->pluck('person_email')->first();


            $sign = Company_site_name::where('id',$request->sign)->pluck('image')->first();
             
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
            $po_data->sign = $sign;
            $po_data->code = $code;

            $po_datas['invoice_product'] = $request->invoice_product;
            $po_datas['description'] = $request->description;
            $po_datas['invoice_product_qty'] = $request->invoice_product_qty;
            $po_datas['quantity_unit'] = $request->quantity_unit;
            $po_datas['invoice_product_price'] = $request->invoice_product_price;
            $po_datas['invoice_product_tax'] = $request->invoice_product_tax;
            $po_datas['total'] = $request->total;
            $po_datas['invoice_product_sub'] = $request->invoice_product_sub;
            $po_datas['comment'] = $request->comment;

            $date = Carbon::parse();
            $po_data->date = $date->format('d-m-Y');

            $po_data->count = count($request->invoice_product);

            $po_data_s['vendor_details_company'] = $vendor_details_company;

            //return view('Generate_Purchase_Order.purchase_order_receipt',compact('po_data','po_datas'));
             $pdf = PDF::loadView('Generate_Purchase_Order.purchase_order_receipt',compact('po_data','po_datas'));

            return $pdf->download('Purchase.pdf');

            // Storage::disk('public')->put('documents/invoice/invoice_' . $purchase->purchase_number . '.pdf', $pdf->output()) ;


            // Mail::send('Generate_Purchase_Order.pomail', $po_data_s, function($message)use($po_data_s,$pdf) {
            //     $message->to('sourabh.joshi.sdbg@gmail.com')
            //             ->subject('Purchase Order Details')
            //             ->attachData($pdf->output(), "PurchaseOrder.pdf");
            // });
            
            // $po_data->save();

            // \Mail::to('sourabh.joshi.sdbg@gmail.com')->send(new SendMailForPurchasOrder($po_data));           

            // return redirect('generate_po')->with('success', 'Purchase Order send PDF Successfully');
        }

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
        $locations = SiteName::where('id',$location)->pluck('name');

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
        $data = prch_quotationwise_requs::where('item_name', 'ILIKE', "%{$query}%")->pluck('description');

        return response()->json($data);
      }

    }


    // public function item_details(Request $request)
    // {
    //     $item_name = $request->post('query');
    //     $data = prch_quotationwise_requs::where('item_name',$item_name)->get();

    //     $output = '';
    //         foreach($data as $row)
    //         {
    //         $output .= ''.$row->description.'';
    //         }
    //     $output .= '';

    //     return response()->json($output);

    // }

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
}
