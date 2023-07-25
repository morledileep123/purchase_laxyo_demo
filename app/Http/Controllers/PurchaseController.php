<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;

use App\Purchase;
use App\Purchase_temperory;
use App\Purchase_item;
use App\purchase_invoice;
use App\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Helper;
use Response;
use App\Company_site_name;
use App\Prch_Notifications;
use App\SiteName;
use App\Prch_Team;
use App\Prch_Team_Person;
use App\User;
use App\unitofmeasurement;
use App\prch_quotationwise_requs;
use App\Purchase_order;
use App\Purchase_order_detail;
use App\vendor;
use DB;
use Auth;
use Carbon\Carbon;
use PDF;
Use Mail;
use \App\Mail\SendPOToVendors;
use Storage;
use App\Notifications\PurchaseOrderInformationNotification;


class PurchaseController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
      $user_id = Auth::user()->id;
      $site_id = Prch_Team_Person::where('user_id',$user_id)->pluck('team_id');
      $generate_po = Purchase_order::where('send_email','=',0)->where('super_admin_status','=',0)->whereIn('team_id',$site_id)->latest()->get();
      
      $approve_po = Purchase_order::where('super_admin_status','!=',0)->whereIn('team_id',$site_id)->latest()->get();
      $items_name = DB::table('prch_order_items_detail')
                 ->select("item_id as id",DB::raw("string_agg(invoice_product,',') as item"))
                 ->groupBy('item_id')
                 ->get();
      
      return view('purchase.index',compact('generate_po','approve_po','items_name'));
    }

    public function create()
    {
        //
    }

    /* this function can be used to store item in session */
    public function store(Request $request)
    { 
      $product = item::where("item_number", $request->item_number)->get();
      $id = $product[0]->id;
      $cart = session()->get('cart');
      if(!$cart) {
        $cart = [
          $id => [
            "item_number" => $product[0]->item_number,
            "name" => $product[0]->title,
            "quantity" => 1
          ]
        ];
        session()->put('cart', $cart);
        return view('purchase.display_item');
      }

      if(isset($cart[$id])) {
        $cart[$id]['quantity']++;
        session()->put('cart', $cart);
        return view('purchase.display_item');
      }

      $cart[$id] = [
        "item_number" => $product[0]->item_number,
        "name" => $product[0]->title,
        "quantity" => 1
      ];
      session()->put('cart', $cart);
      return view('purchase.display_item');
    }

    /* this function can be used to check id wise invoice */
    public function show($id)
    {
      $data = Purchase_order::where('id',$id)->first(); 
      $items = Purchase_order_detail::where('item_id',$id)->get(); 

      if($data->code_location == 1)
      {
        return view('purchase.view_purchase_order_receipt',compact('data','items'));
      }
      else{
        return view('purchase.view_yolax_purchase_order_receipt',compact('data','items'));
      }  
    }

    public function view_approve_po($id)
    {
      $data = Purchase_order::where('id',$id)->first(); 
      $items = Purchase_order_detail::where('item_id',$id)->get(); 

      if($data->code_location == 1)
      {
        return view('purchase.approve_laxyo_purchase_order_receipt',compact('data','items'));
      }
      else{
        return view('purchase.approve_yolax_purchase_order_receipt',compact('data','items'));
      }  
    }

    public function po_pdf_downloads($id)
    {
      $data = Purchase_order::where('id',$id)->first(); 
      $items = Purchase_order_detail::where('item_id',$id)->get();   

      if($data->code_location == 1)
      {
        $pdf = PDF::loadView('purchase.download_laxyo_purchase_order_receipt',compact('data','items'));

        return $pdf->download('Purchase.pdf');
      }
      else{
        $pdf = PDF::loadView('purchase.download_yolax_purchase_order_receipt',compact('data','items'));

        return $pdf->download('Purchase.pdf');
      } 
    }

    public function edit($id)
    {
      $data = Purchase_order::where('id',$id)->first(); 
      $items = Purchase_order_detail::where('item_id',$id)->get(); 

      return view('purchase.edit_purchase_order_receipt',compact('data','items'));
    }

    public function update(Request $request, $id)
    {
      $data = Purchase_order::find($id); 
      $data->code =  $request->get('code'); 
      $data->date =  $request->get('date');  
      $data->vender_detail =  $request->get('vender_detail');  
      $data->vender_email =  $request->get('vender_email');  
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

      $data->terms1 = $request->get('terms1'); 
      $data->terms2 = $request->get('terms2'); 
      $data->terms3 = $request->get('terms3'); 
      $data->guarantee = $request->get('guarantee'); 
      $data->invoice_subtotal = $request->get('invoice_subtotal'); 
      $data->invoice_discount = $request->get('invoice_discount');
      $data->delivery_date = $request->get('delivery_date');
      $data->delivery_address = $request->get('delivery_address');
      $data->perosn_name = $request->get('perosn_name');
      $data->sign = $request->get('sign');
      // dd($data);
      $data->save();  
      return redirect('purchase')->with('success','purchase order details updated successfully');
    }

    /* this function can be used to delete single item */
    public function destroy(Request $request, $id)
    {
      if($id || $id == false) {
        $cart = session()->get('cart'); 
        if(isset($cart[$id])) { 
            unset($cart[$id]); 
            session()->put('cart', $cart);
        }
        session()->flash('success', 'Product removed successfully');
        return redirect()->route('purchase.index')->with('success','Item deleted successfully');
      }
    }

    /* this function can be used to search items */
    public function fetch(Request $request)
    {
      if($request->get('query'))
      {
        $query = $request->get('query');
        $data = item::where('title', 'LIKE', "%{$query}%")->orWhere('item_number', 'LIKE', "%{$query}%")->get();
        $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
        if(count($data) != null)
        {
          foreach($data as $row)
          {
            $output .= '<li><a id="getItemID" href="?itemId='.$row->id.'" style="pointer-events: none;" value="'.$row->id.'">'.$row->title .' | '.$row->item_number.'</a></li>';
          }
        }
        else
        {
          $output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
        }
        $output .= '</ul>';
        echo $output;
      }
    }

    /* this function can be used to update quantity on input field */
    public function updateQty(Request $request)
    {
      $cart = session()->get('cart');
      $id = $request->id;
      $quantity = $request->quantity;
      if($quantity > 0){
        if(isset($cart[$id])) {
          $cart[$id]['quantity'] = $quantity;
          session()->put('cart', $cart);
        }
      }
    }

    /* this function can be used to store cart data on hold by clicking Hold btn */
    public function holdStatus(Request $request)
    {
      $cart = session()->get('cart');
      if(!empty($cart))
      { 
        Helper::emptyCart('cart');
        $data = Purchase_temperory::all();
        if(count($data))
        {
          $persist = Purchase_temperory::latest()->first();
          $persist->temp_data = json_encode($cart);
          $persist->save();
          return redirect()->route('purchase.index')->with('success','Your items are added on Hold.');
        }
        else
        {
          $persist = new Purchase_temperory;
          $persist->temp_data = json_encode($cart);
          $persist->save();
          return redirect()->route('purchase.index')->with('success','Your items are added on Hold.');
        }
      }
      else
      {
        return redirect()->route('purchase.index')->with('alert','First select any items');
      }
    }

    /* this function can be used to generate invoice by clicking generate btn */
    public function invoice(Request $request)
    {
      $cart = session()->get('cart');
      if(!empty($cart))
      {
        Helper::emptyCart('cart');
        $Purchase_item = Purchase_item::with('item_name.unit')->get();
        if(!empty($Purchase_item))
        {
          Purchase_item::query()->truncate();
        }
        $arr = array(
          //'invoice_no' => date("Ym").'/'.mt_rand(00000, 99999).'/'.count($cart),
          'invoice_no' => $this->generateInvoiceNumber(),
          'items' => json_encode($cart)
        );
        foreach ($cart as $value) {
          $data = array(
            'invoice_no' => $arr['invoice_no'],
            'item_number' => $value['item_number'], 
            'quantity' => $value['quantity'], 
          );
          Purchase::create($data);
        }
        Purchase_item::create($arr);
        purchase_invoice::create($arr);
        $purchases = Purchase_item::all();
        return view('purchase.invoice',compact('purchases'));
      }
      else
      {
        return redirect()->route('purchase.index')->with('alert','First select any items');
      }
    }

    /* this function can be used to restore hold cart data by clicking Restore cart item text */
    public function cartRestore()
    {
      $temp = Purchase_temperory::latest()->first();
      $id = $temp['id'];
      $temps = json_decode($temp['temp_data'], true);
      $cart = $temps;
      $new_session = session()->get('cart');
      if(!empty($new_session)){
        foreach ($new_session as $key => $val) {
          $latest_id = $key;
          if(isset($cart[$latest_id])) {
            $cart[$latest_id]['quantity']++;
            $data = $cart;
          }
        }
      }else{
        $data = $cart;
      }
      session()->put('cart', $data);
      Purchase_temperory::find($id)->delete();
      return redirect()->route('purchase.index');
    }

    /* this function can be used to generate invoice number */
    public function generateInvoiceNumber()
    {
      $getNum = purchase_invoice::latest()->first();
      if(!empty($getNum))
      {
        $num = $getNum->id+1;
      }
      else
      {
        $num = 0+1;
      }
      $invoice_num = str_pad($num, 5, '0', STR_PAD_LEFT);
      return date("Y-m-").$invoice_num;
    }


    public function remove_req_purchase_order(Request $request)
    {
      $super_admin_id = Auth::user()->id;
    
      $request->validate([
         'dispatch_reason' => 'required',
      ]);
      $data = Purchase_order::find($request->id);

      $data->super_admin_id = $super_admin_id;
      $data->super_admin_status = 'D';
      $data->dispatch_reason = $request->dispatch_reason;

      $data->save();
      
      return redirect('purchase')->with('success','Purchase Order decline Successfully');
    }

    public function approve_req_purchase_order(Request $request)
    {
      // return $request->id;
      $super_admin_id = Auth::user()->id;
      $data = Purchase_order::find($request->id);
      $data->super_admin_id = $super_admin_id;
      $data->super_admin_status = 'A';

      $data->save();  

      // $user = User::find(21);
      // Notification::send($user, New PurchaseOrderInformationNotification);
      // $notifi_data = new Prch_Notifications;
      // $notifi_data->notifiable_id = $super_admin_id;
      // $notifi_data->notifiable_to = $user->id;
      // $notifi_data->data = 'Information about Purchase Order';
      // $notifi_data->save();
        
      return redirect('purchase')->with('success','Purchase Order Approve Successfully');
    }

    // Accountant Section start

    public function purchase_order_inform()
    {
      $approve_po = Purchase_order::latest()->get();
      // $approve_po = Purchase_order::where(['send_email'=>'1'],['dispatch_reason'=>'NULL'])->latest()->get();

      return view('purchase.accountant_index',compact('approve_po'));
    }

    public function purchase_order_inform_download($id)
    {
      $data = Purchase_order::where('id',$id)->first(); 
      $items = Purchase_order_detail::where('item_id',$id)->get();       
        
      if($data->code_location == 1)
      {
        $pdf = PDF::loadView('purchase.download_laxyo_purchase_order_receipt',compact('data','items'));

        return $pdf->download('Purchase.pdf');
      }
      else{
        $pdf = PDF::loadView('purchase.download_yolax_purchase_order_receipt',compact('data','items'));

        return $pdf->download('Purchase.pdf');
      }
    }

    public function purchase_order_view($id)
    {
      $data = Purchase_order::where('id',$id)->first(); 
      $items = Purchase_order_detail::where('item_id',$id)->get(); 

      return view('purchase.accountant_view_purchase_order_receipt',compact('data','items'));
    }
}
