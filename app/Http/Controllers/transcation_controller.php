<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\RequestForItem;
use Auth;
use App\Member;
use App\vendor;
use App\Vendormain;
use App\item;
use App\SiteName;
use App\unitofmeasurement;
use App\RfiUsers;
use App\RfiManager;
use App\RfiDiscardReason;
use App\User;
use App\VendorsMailSend;
use App\Warehouse;
use App\IndentReq;
use App\Send_quotation;
use App\Items_quotation;
use App\Vendor_request;
use App\sites;
use App\prch_itemwise_requs;
use App\prch_quotationwise_requs;
use App\RfQUsers;
use App\RFQManager;
use App\RFQAdmin;
use App\RFQSuperAdmin;
use App\RFQHOD;
use App\QuotationReceived;
use App\Model\store_inventory\StoreItem;
use App\Notifications\RFQ_Notification;
use \App\Mail\SendMailToVendors;
use \App\Mail\SendMailToVendor;
use \App\Mail\SendMailToMang;
use \App\Mail\SendMailToAdmin;
use Laravel\LegacyEncrypter\McryptEncrypter;
use PDF;
use DB;
use Helper;

class transcation_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $data = DB::table('prch_req_quotation')
             ->select("user_id","prch_rfi_users_id as id","created_at","expected_date",DB::raw("string_agg(item_name,',') as item"))
             ->where('requested_role','Users')->where('remove_item_status','=',0)
             ->groupBy('user_id','prch_rfi_users_id','created_at','expected_date')
             ->orderBy('created_at','DESC')
             ->paginate(10);
  
        return view('Transaction.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unitofmeasurement::get();
        $sites = SiteName::all();
        
        $site = sites::where('deleted_at',NULL)->orderBy('job_describe')->get();
        return view('Transaction.create', compact('site','units','sites'));
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
        $valid = $request->validate([
           'site_id' => 'required',
           'expected_date.*'   => 'required|date',
        ]);

        $data =  $this->validate($request,[
         'item_name.*'   => 'required|distinct',
         'quantity.*'   => 'required|integer',
         'quantity_unit.*'   => 'required',
        ]); 

        $id = Auth::user()->id;
        $user = User::find(Auth::user()->id);
        $rolename = $user->hasRole('purchase_user'); //$role[0]->name;

        $count = count($request->item_name);    
            if($count != 0){
                $x = 0;
                $data = array();
                        
                while($x < $count){
                    if($request->item_name[$x] !=''){
                        $RequestForItem = array(
                            'item_name' => $request->item_name[$x],
                            'quantity' => $request->quantity[$x],
                            'quantity_unit' => $request->quantity_unit[$x],
                            'description' => $request->description[$x],
                            'remark' => $request->remark[$x],
                            'user_id' => $request->user_id[$x],
                            'expected_date' => $request->expected_date,
                        );
                         $data[] = $RequestForItem;
                    }
                    $x++;
                }
      
                $request_data = new RfQUsers;
                $request_data->requested_data = json_encode($data);
                $request_data->user_id = $id;
                $request_data->requested_role = ($rolename == 'true') ? 'Users' : 'Manager';
                $request_data->save();
                $lastid = $request_data->id;
             
                $request_data = new RfQManager;
                $request_data->requested_data = json_encode($data);
                $request_data->requested_id = $id;
                $request_data->prch_id = $lastid;
                $request_data->save();

                $request_data = new RfQAdmin;
                $request_data->requested_data = json_encode($data);
                // $request_data->requested_id = $id;
                $request_data->prch_id = $lastid;
                $request_data->save();

                $request_data = new RfQSuperAdmin;
                $request_data->requested_data = json_encode($data);
                $request_data->requested_id = $id;
                $request_data->prch_id = $lastid;
                $request_data->save();

                $request_data = new RfQHOD;
                $request_data->requested_data = json_encode($data);
                $request_data->requested_id = $id;
                $request_data->prch_id = $lastid;
                $request_data->save();

               $i = 0;


          while($i < $count){
            if($request->item_name[$i] !=''){
              $itno = explode("|",$request->item_name[$i]);
            
              $itname = $itno[0];
              $newdata = array(
                  
                  'quantity' => $request->quantity[$i],
                  'quantity_unit' => $request->quantity_unit[$i],
                  'description' => $request->description[$i],
                  'remark' => $request->remark[$i],
                  'user_id' => $request->user_id[$i],
                  'item_name' => $itname,
                  'prch_rfi_users_id' => $lastid,                
                  'expected_date' => $request->expected_date,
                  'requested_role' => ($rolename == 'true') ? 'Users' : 'Manager',
                  //'manager_status' => ($rolename == 'true') ? 0 : 1,
                  'squantity' => ($rolename != 'true') ? $request->quantity[$i] : 0,
                  'site_id' => $request->site_id,

              );
            
            prch_quotationwise_requs::create($newdata);

            }       
            $i++;
          }
            

            }
        return redirect()->route('transcation.index')->with('success','Your RFI Added and mailed it to Manager successfully.');

    }

    public function check_users_rfq(Request $request, $id)
    {
        $data = prch_quotationwise_requs::where('prch_rfi_users_id',$id)->get();
        return view('Transaction.show_user',compact('data'));
    }



    //  ------------------- MANAGER SECTION START -------------------
    public function request_qutation_manager()
    {
        $user_id = Auth::user()->id;
        //$data = prch_quotationwise_requs::all();
        $data = DB::table('prch_req_quotation')
             ->select("user_id","prch_rfi_users_id as id","created_at","expected_date",DB::raw("string_agg(item_name,',') as item"))
             ->where('requested_role','Users')->where('remove_item_status','=',0)
             ->groupBy('user_id','prch_rfi_users_id','created_at','expected_date')
             ->orderBy('created_at','DESC')
             ->paginate(10);
        
        return view('Transaction.show_manger',compact('data'));
    }

    public function check_manager_rfq($id)
    {
        $detail = prch_quotationwise_requs::where('prch_rfi_users_id',$id)->where('remove_item_status','=',0)->first();
        $data = prch_quotationwise_requs::where('prch_rfi_users_id',$id)->where('remove_item_status','=',0)->where('item_status','=',0)->get();
        return view('Transaction.edit_manager',compact('data','detail'));

    }

    public function removerequestquotation($id){
        prch_quotationwise_requs::where('id',$id)->update(['remove_item_status'=>3,'item_status'=>3]);
        return redirect()->back()->with('success','Quotation Item is Removed successfully');
    }

    public function send_manager_rfq(Request $request)
    {
        // return $request;
        $id = Auth::user()->id;
        $user = User::find(Auth::user()->id);
        $rolename = $user->hasRole('purchase_user'); //$role[0]->name;

        $affectedRows = RfQUsers::where("id",$request->prch_rfi_users_id)->update(["manager_status" => 1]);
 
        $affectedRows = RfQManager::where("prch_id",$request->prch_rfi_users_id)->update(["approval_id"=>$id ,"approval_status" => 1]);
        $count = count($request->item_name);
        $i = 0;
        while($i < $count){
            if($request->item_name[$i] !=''){
              
              $newdata = array(
                  'squantity' => $request->squantity[$i],
                  'manager_status' => 1,
              );
            //dd($newdata);
            prch_quotationwise_requs::where('item_name',$request->item_name[$i])->update($newdata);

            }       
            $i++;
        }
        
        return redirect()->back()->with('success','Your RFQ send and mailed it to Manager successfully.');

    }
//  ------------------- MANAGER SECTION END -------------------
//  ------------------- ADMIN SECTION START -------------------

    public function admin_request_show()
    {
        $user_id = Auth::user()->id;
        //$data = prch_quotationwise_requs::all();
        $data = DB::table('prch_req_quotation')
             ->select("user_id","prch_rfi_users_id as id","created_at","site_id","expected_date",DB::raw("string_agg(item_name,', ') as item"))
             ->where('requested_role','Users')->where('manager_status','=',1)
             ->groupBy('user_id','prch_rfi_users_id','created_at','expected_date','site_id')
             ->orderBy('created_at','DESC')
             ->paginate(10);
        return view('Transaction.show_admin',compact('data'));
    }

     public function check_admin_rfq($id)
    {
        $detail = prch_quotationwise_requs::where('prch_rfi_users_id',$id)->where('level1_status','=',0)->first();
        $data = prch_quotationwise_requs::where('prch_rfi_users_id',$id)->where('level1_status','=',0)->where('item_status','=',0)->get();
        return view('Transaction.detail_rfq',compact('data','detail'));

    }



 
//  ------------------- ADMIN SECTION END -------------------


    public function vendor_form()
    {   
        return View('vendor_from');
    }




        // return $request;
        // $id = Auth::user()->id;
        // $user = User::find(Auth::user()->id);
        // $rolename = $user->hasRole('purchase_user'); //$role[0]->name;

        // $affectedRows = RfQUsers::where("id",$request->prch_rfi_users_id)->update(["manager_status" => 1]);
 
        // $affectedRows = RfQManager::where("prch_id",$request->prch_rfi_users_id)->update(["approval_id"=>$id ,"approval_status" => 1]);

        // $count = count($request->item_name);    
        //     if($count != 0){
            
        //         $i = 0;

        //       while($i < $count){
        //         if($request->item_name[$i] !=''){
                   
        //           $newdata = array(
        //               'item_name' => $request->item_name[$i],
        //               'squantity' => $request->squantity[$i],
        //               'manager_status' => 1,

        //           );
        //           dd($newdata);
                     

        //         //prch_quotationwise_requs::where('prch_rfi_users_id',$request->prch_rfi_users_id)->update($newdata);
            
            
        //         }  
        //         $i++;
        //     // dd($i);         
        //       }
            
        //     }
        // return redirect()->route('transcation.index')->with('success','Your RFI Added and mailed it to Manager successfully.');

    //  ------------------- MANAGER SECTION END -------------------

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

    public function so_create()
    {
        return view('Transaction.so-create');
    }

    public function oc_create()
    {
        return view('Transaction.oc-create');
    }

    public function sc_create()
    {
        return view('Transaction.sc-create');
    }

    public function inc_create()
    {
        return view('Transaction.inc-create');
    }

    public function adhinc_create()
    {
        return view('Transaction.adhinc-create');
    }
}
