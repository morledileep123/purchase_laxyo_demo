<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

use Illuminate\Http\Request;
use App\Invoice;
use App\Invoice_details;
use App\unitofmeasurement;
use App\vendor;
use App\SiteName;
use App\User;
use App\item;
use App\Prch_Team;
use App\Prch_Team_Person;
use App\Prch_Notifications;
use App\prch_quotationwise_requs;
use App\Company_site_name;
use App\Notifications\UserGRRRequestNotification;
use App\Notifications\ManagerGRRRequestNotification;
use App\Notifications\AdminGRRRequestNotification;
use App\Notifications\SuperadminGRRRequestNotification;
use DB;
use Carbon\Carbon;
use PDF;
Use Mail;
use Storage;
use Auth;

class GoodsReceivedNoteController extends Controller
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

      $invoices = Invoice::whereIn('team_id',$site_id)->orderBy('created_at', 'desc')->paginate(10);

      return view('Invoices.index',compact('invoices'));
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
      $items_lists = item::pluck('item_name');
      $sites = SiteName::all();
      $items = prch_quotationwise_requs::where('manager_status','=',1)->where('item_status','=',0)->pluck('item_name');

      return view('Invoices.create_grr',compact('vendors','units','sites','items','items_lists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      return $request;
      // $user = User::find(222);
      // Notification::send($user, New UserGRRRequestNotification);
      // return back();

      // $reseve = 'sourabh.joshi.sdbg@gmail.com';
      // $data = [];
      // Mail::send('Invoices.send_mail_to_manager', $data, function($message) use($reseve)
      // {
      //     $message->to($reseve)->subject('Your Side user send GRR !');                
      // });
      // return back();


      $id = Auth::user()->id;
      $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');

      $side_id = Prch_Team::where('side_id',$request->delivery_location)->first();
      $manager_id = Prch_Team_Person::where('team_id',$side_id->id)->where('role',22)->get();

      foreach($manager_id as $rows){
        $user = User::find($rows->user_id);
        Notification::send($user, New UserGRRRequestNotification); 

        $notifi_data = new Prch_Notifications;
        $notifi_data->notifiable_id = $id;
        $notifi_data->notifiable_to = $user->id;
        $notifi_data->data = 'Your Site User Send GRR Request';
        $notifi_data->page_link = 'https://purchase.laxyo.org/manager_grr_index';
        $notifi_data->save(); 
      }

      $company = SiteName::where('id',$request->delivery_location)->first();
      $short_key_name = $company->site_shortkey;
      $grn_no = '#GRR'.'-'.$short_key_name.'-'.substr($string, 0,4);

      if($request->vender_details != 'abc') {
        $single_vender_details = Vendor::where('id',$request->vender_details)->first();  
      }
        
      $data = new Invoice;

      $data->user_id = $request->user_id;
      $data->grn_no = $grn_no;
      $data->invoice_no = $request->invoice_no;
      $data->invoice_date = $request->invoice_date;
      $data->delivery_location = $company->site_name_detail;
      $data->counter = $request->counter;
      $data->grr_date = $request->grr_date;
      $data->po_no = $request->po_no;
      $data->counter = $request->counter;
      $data->po_date = $request->po_date;
      $data->delivery_date = $request->delivery_date;
      $data->comments = $request->comments;
      $data->grand_total = $request->grand_total;
      $data->amount_rupees = $request->amount_rupees;
      $data->team_id = $side_id->id;
      $data->manager_status = 1;

      if ($request->vender_details == 'abc') {
        $data->vender_detail_infor = $request->vender_detail_infor;
      } else {
        $data->vender_company = $single_vender_details->company;
        $data->vender_email = $single_vender_details->company_email;
        $data->vender_address1 = $single_vender_details->address1;
        $data->vender_address2 = $single_vender_details->address2;
        $data->vender_state = $single_vender_details->state;
        $data->vender_city = $single_vender_details->city;
        $data->vender_person_name = $single_vender_details->person_name;
        $data->vender_person_email = $single_vender_details->person_email;
        $data->vender_person_no = $single_vender_details->company_mobile;
      }

      if($request->hasfile('invoice_doc')) {
        $file = $request->file('invoice_doc');
        $filename = 'assets/Invoices/'.time().'-'.$file->getClientOriginalName();
        $file->move(public_path().'/assets/Invoices',$filename);
        $data->invoice_doc = $filename;
      }

      if($request->hasfile('lorry_receipt_doc')) {
        $file = $request->file('lorry_receipt_doc');
        $filename = 'assets/LorryReport/'.time().'-'.$file->getClientOriginalName();
        $file->move(public_path().'/assets/LorryReport',$filename);
        $data->lorry_receipt_doc = $filename;
      }

      $data->save();
      
      $item_id = $data->id;

      $count = count($request->item_name);

      $i = 0;
      while($i < $count){

      $string = str_shuffle('12ABCDJIKJGTIRO41581425123GJAIKOUJWUHENBJFJSUHAFRJE3456FASDFSD56456FA4SD5F4S57890');
      $invoice_no_code = substr($string, 0,7);

        if($request->item_name[$i] !=''){
          $newdata = array(
            'item_id' => $item_id,
            'invoice_no_code' => $invoice_no_code,                      
            'item_name' => $request->item_name[$i],
            'invoice_qty' => $request->invoice_qty[$i],
            'approve_items' => $request->approve_items[$i],
            'description' => $request->description[$i],
          );
          
        Invoice_details::create($newdata);

        }       
        $i++;
      }

      return redirect('GoodsReceivedNote')->with('success','GRR generate successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get(); 

      return view('Invoices.view_invoice',compact('data','items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get(); 
       return view('Invoices.edit',compact('data','items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
      $data = Invoice::find($id); 
      
      $data->comments =  $request->get('comments'); 
         
      $count = count($request->invoice_no_code);
      for($x = 0; $x < $count; $x++) {
        $input = [
          'invoice_qty' => $request->invoice_qty[$x],
          'approve_items' => $request->approve_items[$x],              
        ];
      Invoice_details::where(['item_id'=>$id,'invoice_no_code' => $request->invoice_no_code[$x]])->update($input);
      }
    
      $data->save();  
      return back()->with('success','GRR updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $data=Invoice::find($request->invoice_id);
      $data->delete();
      return back()->with('delete', 'GRN deleted Successfully');
    }

    public function invoicedownloaduser($id)
    {
      
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get();       
        
      // return view('Invoices.download_invoice_receipt',compact('data','items'));
      $pdf = PDF::loadView('Invoices.download_invoice_receipt',compact('data','items'));

      return $pdf->download('GRR.pdf');
    }

    public function send_vendor_invoice(Request $request)
    {
        $svendor = $request->post('query');
        $svendors = Vendor::where('id',$svendor)->get();

        $output = '';
        foreach($svendors as $row)
{
$output .= 'Company Name : '.$row->company .' 
Company email : '.$row->company_email.'
Address 1 : '.$row->address1.'
Address 2 : '.$row->address2.'
City : '.$row->city.'
State : '.$row->state.'
Person name : '.$row->person_name   .'
Person Email : '.$row->person_email.'
Person Mobile : '.$row->company_mobile.'
';

}
        $output .= '';

        echo $output;
    }


    public function company_details(Request $request)
    {
      $query = $request->get('company');
      $data = Company_site_name::where('id',$query)->pluck('full_address');
      return response()->json($data);
    }

    public function sendmanager($id)
    {
      // return $id;
      $user_id = Auth::user();
      $sender = $user_id->email;

      if($user_id->id == '223') {
        $resever_data = User::find(29);
        $reseve = 'sourabh.joshi.sdbg@gmail.com';

        $data = [];
        Mail::send('Invoices.send_mail_to_manager', $data, function($message) use($reseve,$sender)
        {
            $message->to($reseve)->subject('Your Side user send GRR !');
            $message->from($sender);
            
        });
      }
      elseif(condition){
        return "else if condition";
      }
      else{
        return "else condition";
      }

      $manager_id = $resever_data->id;
      $datas = Invoice::where('id',$id)->update(['user_send_grr'=>1,'manager_status'=>1,'manager_id'=>$manager_id]);
      return redirect('GoodsReceivedNote')->with('success' , 'GRR Send to manager.'); 

    }


    // all role show approve GRR View
    public function GGRApproveShow($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get(); 

      return view('Invoices.Approve_view_grr',compact('data','items'));
    }

    // download all role 
    public function GGRApproveDownload($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get();       
        
      $pdf = PDF::loadView('Invoices.download_invoice_receipt',compact('data','items'));

      return $pdf->download('GRR.pdf');
    }

    // Hold all role 
    public function hold_grr_reason(Request $request,$id)
    {
      $data = Invoice::find($id); 

      $data->hold_status = 1;
      $data->hold_reason = $request->hold_reason;

      $data->save();
      return back();
    }

    // un approve grr view all
    public function unapprove_grr_view($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get(); 

      return view('Invoices.unapprove_grr_view',compact('data','items'));
    }


    // Manager Section start

    public function manager_grr_index()
    {
      $user_id = Auth::user()->id;
      $site_id = Prch_Team_Person::where('user_id',$user_id)->pluck('team_id');
      $invoices = Invoice::where(['manager_status'=>'1','manager_aprove'=>0])->whereIn('team_id',$site_id)->latest()->get();
      $invoices_send = Invoice::where(['manager_status'=>'1','manager_aprove'=>1])->whereIn('team_id',$site_id)->latest()->get();

      return view('Invoices.manager_index',compact('invoices','invoices_send'));
    }

    public function manager_grr_view($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get(); 

      return view('Invoices.view_manager',compact('data','items'));
    }

    public function invoicedownloadmanager($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get();       
        
      // return view('Invoices.download_invoice_receipt',compact('data','items'));
      $pdf = PDF::loadView('Invoices.download_invoice_receipt',compact('data','items'));

      return $pdf->download('GRR.pdf');
    }

    public function reject_invoice(Request $request,$id)
    {
      $data = Invoice::find($id); 

      $data->decline_status = 1;
      $data->decline_reason = $request->reject;

      $data->save();
      return back(); 

    }

    public function sendadmin(Request $request,$id)
    {
      // return $request;
      $user_id = Auth::user()->id;
      $side_id = Prch_Team::where('id',$request->team_id)->first();
      $admin_id = Prch_Team_Person::where('team_id',$side_id->id)->where('role',20)->get();

      foreach($admin_id as $rows){
        $user = User::find($rows->user_id);
        Notification::send($user, New ManagerGRRRequestNotification); 

        $notifi_data = new Prch_Notifications;
        $notifi_data->notifiable_id = $id;
        $notifi_data->notifiable_to = $user->id;
        $notifi_data->data = 'Your Site Manager Send GRR Request';
        $notifi_data->page_link = 'http://purchase.laxyo.org/admin_grr_index';
        $notifi_data->save(); 
      }

      $datas = Invoice::where('id',$request->id)->update(['manager_aprove'=>1,'admin_status'=>1,'manager_id'=>$user_id]);
      return redirect('manager_grr_index')->with('success' , 'Send to Admin.'); 
    }



//  Admin Section start

    public function admin_grr_index()
    {
      $user_id = Auth::user()->id;
      $site_id = Prch_Team_Person::where('user_id',$user_id)->pluck('team_id');
      $invoices = Invoice::where(['admin_status'=>1,'admin_approve'=>0])->whereIn('team_id',$site_id)->get();
      $invoices_send = Invoice::where(['admin_status'=>1,'admin_approve'=>1])->whereIn('team_id',$site_id)->get();

      return view('Invoices.admin_index',compact('invoices','invoices_send'));
    }

    public function admin_grr_view($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get(); 

      return view('Invoices.view_admin',compact('data','items'));
    }

    public function admin_grr_approve_view($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get(); 

      return view('Invoices.view_admin',compact('data','items'));
    }

    public function invoicedownloadadmin($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get();       
        
      // return view('Invoices.download_invoice_receipt',compact('data','items'));
      $pdf = PDF::loadView('Invoices.download_invoice_receipt',compact('data','items'));

      return $pdf->download('GRR.pdf');
    }

    public function sendsuperadmin(Request $request)
    {
      // return $request;
      $id = Auth::user()->id;

      $side = Prch_Team::where('id',$request->team_id)->first();
      $manager_id = Prch_Team_Person::where('team_id',$side->id)->where('role',21)->get();

      foreach($manager_id as $rows){
        $user = User::find($rows->user_id);
        Notification::send($user, New AdminGRRRequestNotification); 

        $notifi_data = new Prch_Notifications;
        $notifi_data->notifiable_id = $id;
        $notifi_data->notifiable_to = $user->id;
        $notifi_data->data = 'Your Manager Send GRR Request';
        $notifi_data->page_link = 'http://purchase.laxyo.org/superadmin_grr_index';
        $notifi_data->save(); 
      }

      $datas = Invoice::where('id',$request->id)->update(['admin_approve'=>1,'superadmin_status'=>1,'admin_id'=>$id,'admin_comment'=>$request->admin_comment]);
      return redirect('admin_grr_index')->with('success','Send to Super admin.'); 
    }

    public function admin_send_po_quantity(Request $request)
    {
      $datas = Invoice_details::where('id',$request->id)->update(['po_qty'=>$request->po_qty]);
      return back();
    }


    // Super Admin Section start

    public function superadmin_grr_index()
    {
      $user_id = Auth::user()->id;
      $site_id = Prch_Team_Person::where('user_id',$user_id)->pluck('team_id');
      $invoices = Invoice::where(['superadmin_status'=>'1','superadmin_approve'=>0])->whereIn('team_id',$site_id)->get();
      $invoices_send = Invoice::where(['superadmin_status'=>'1','superadmin_approve'=>1])->whereIn('team_id',$site_id)->get();

      return view('Invoices.superadmin_index',compact('invoices','invoices_send'));
    }

    public function superadmin_grr_view($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get(); 

      return view('Invoices.view_superadmin',compact('data','items'));
    }

    public function invoicedownloadsuperadmin($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get();       
        
      // return view('Invoices.download_invoice_receipt',compact('data','items'));
      $pdf = PDF::loadView('Invoices.download_invoice_receipt',compact('data','items'));

      return $pdf->download('GRR.pdf');
    }

    public function sendaccount(Request $request)
    {
      // return $request;
      $id = Auth::user()->id;

      $side = Prch_Team::where('id',$request->team_id)->first();
      $manager_id = Prch_Team_Person::where('team_id',$side->id)->where('role',16)->get();

      foreach($manager_id as $rows){
        $user = User::find($rows->user_id);
        Notification::send($user, New SuperadminGRRRequestNotification); 

        $notifi_data = new Prch_Notifications;
        $notifi_data->notifiable_id = $id;
        $notifi_data->notifiable_to = $user->id;
        $notifi_data->data = 'Sir Send GRR Request';
        $notifi_data->page_link = 'http://purchase.laxyo.org/accountant_grr_index';
        $notifi_data->save(); 
      }

      $datas = Invoice::where('id',$request->id)->update(['superadmin_approve'=>1,'acountent_status'=>1,'superadmin_id'=>$id,'superadmin_comment'=>$request->superadmin_comment]);
      return redirect('superadmin_grr_index')->with('success' , 'Send to Accountant.'); 
      
    }




    
    // Accountant Section start

    public function accountant_grr_index()
    {
      $invoices = Invoice::where(['acountent_status'=>'1','acountent_approve'=>0])->get();
      $invoices_send = Invoice::where(['acountent_status'=>'1','acountent_approve'=>1])->get();

      return view('Invoices.accountant_index',compact('invoices','invoices_send'));
    }

    public function accountant_grr_view($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get(); 

      return view('Invoices.view_accountant',compact('data','items'));
    }

    public function invoicedownloadaccountant($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      $items = Invoice_details::where('item_id',$id)->get();       
        
      // return view('Invoices.download_invoice_receipt',compact('data','items'));
      $pdf = PDF::loadView('Invoices.download_invoice_receipt',compact('data','items'));

      return $pdf->download('GRR.pdf');
    }

    public function sendapprove($id)
    {
      $data = Invoice::where('id',$id)->first(); 
      return view('payment.grr_payment',compact('data'));
      // $datas = Invoice::where('id',$id)->update(['acountent_approve'=>1,'approve'=>1 ]);
      // return redirect('accountant_grr_index')->with('success' , 'Approve Successfully.'); 
    }


}
