<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;

use Illuminate\Http\Request;
use Auth;
use App\unitofmeasurement;
use App\Member;
use App\RfiUsers;
use App\RfiManager;
use App\RfiDiscardReason;
use App\SiteName;
use App\item;
use App\User;
use App\Prch_Notifications;
use App\prch_itemwise_requs;
use App\Prch_Team;
use App\Prch_Team_Person;
use \App\Mail\SendMailToSadmin;
use App\Notifications\ManagerRequestNotification;
use DB;

class RequestForItemManagerController extends Controller
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
        
        $request_for_items = DB::table('prch_req_itemwise')
                 ->select("prch_rfi_id as id","created_at","user_id","count","request_date","expected_date","manager_status","manager_approve","admin_approve","purchase_status",DB::raw("string_agg(item_name,',') as item"))
                 ->whereIn('team_id',$site_id)
                 ->where(['manager_status'=>1,'manager_approve'=>0,'dispatch_status'=>0])
                 ->groupBy('prch_rfi_id','created_at','user_id','count','expected_date','request_date','manager_status','manager_approve','admin_approve','purchase_status')
                 ->orderBy('created_at', 'desc')->paginate(10);
             // return (count($requested));
        $mngarrrove = DB::table('prch_req_itemwise')
                 ->select("prch_rfi_id as id","created_at","user_id","count","request_date","expected_date","manager_status","manager_approve","admin_approve","purchase_status",DB::raw("string_agg(item_name,',') as item"))
                 ->whereIn('team_id',$site_id)
                 ->where(['manager_approve'=>1])
                 ->groupBy('prch_rfi_id','created_at','user_id','count','expected_date','request_date','manager_status','manager_approve','admin_approve','purchase_status')
                 ->orderBy('created_at', 'desc')->paginate(10);

        $hold_datas = DB::table('prch_req_itemwise')
                 ->select("prch_rfi_id as id","created_at","user_id","count","request_date","expected_date","manager_status","manager_approve","admin_approve","purchase_status",DB::raw("string_agg(item_name,',') as item"))
                 ->whereIn('team_id',$site_id)
                 ->where('hold_status',1)
                 ->groupBy('prch_rfi_id','created_at','user_id','count','expected_date','request_date','manager_status','manager_approve','admin_approve','purchase_status')
                 ->orderBy('created_at', 'desc')->paginate(10);

        // return $hold_data = prch_itemwise_requs::where('hold_status',1)->whereIn('team_id',$site_id)->get();
                
        return view('level_one.view_manager', compact('request_for_items','mngarrrove','hold_datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = prch_itemwise_requs::with('quantitystored')->where(['prch_rfi_id'=>$id,'manager_status'=>1])->get();
        $item_numbers = prch_itemwise_requs::with('quantitystored')->where(['prch_rfi_id'=>$id])->pluck('item_no');

        foreach($item_numbers as $stock) {
            $mem[] = item::where('item_number',$stock)->pluck('current_stock');
        }
        return view('level_one.manager_rfi_approved',compact('data','mem'));
    }

    // Decline Reason Store
    public function removereqitem(Request $request){
        $request->validate([
           'dispatch_reason' => 'required',
        ]);
        $data=prch_itemwise_requs::find($request->id);
        
        $data->dispatch_status = 1;
        $data->dispatch_reason = $request->dispatch_reason;

        $data->save();
        
        return redirect()->back()->with('success','Item Removed Successfully');
    }

    // Hold Reason Store
    public function holdrequestitem(Request $request){
        $request->validate([
           'hold_reason' => 'required',
        ]);
        $datas = prch_itemwise_requs::find($request->hold_id);
        
        $datas->hold_status = 1;
        $datas->hold_reason = $request->hold_reason;

        $datas->save();
        
        return redirect()->back()->with('success','Item Hold Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = prch_itemwise_requs::with('quantitystored')->where(['prch_rfi_id'=>$id,'manager_status'=>1])->get();
        $item_numbers = prch_itemwise_requs::with('quantitystored')->where(['prch_rfi_id'=>$id])->pluck('item_no');

        foreach($item_numbers as $stock) {
            $mem[] = item::where('item_number',$stock)->pluck('current_stock');
        }
        return view('level_one.manager_approval',compact('data','mem'));
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
        $user_id = Auth::user()->id;
        $affectedRows = RfiManager::where("id",$id)->update(["approval_id"=>$id ,"level1_status" => 1]);
        $count = count($request->item_name);
        $i = 0;
        while($i < $count){
            if($request->item_name[$i] !=''){
              
                $newdata = array(
                    'm_quantity' => $request->m_quantity[$i],
                    'manager_approve' => 1,
                    'admin_status' => 1,
                    'admin_id' => $user_id,
                );
            
            prch_itemwise_requs::where(['prch_rfi_id'=>$id,'item_code'=>$request->item_code[$i]])->update($newdata);

            }       
            $i++;
        }

        $usersmail = User::has('prchadmin')->get();
        foreach($usersmail as $mail){
            // Notification::send($mail, New ManagerRequestNotification);
            $notifi_data = new Prch_Notifications;
            $notifi_data->notifiable_id = $user_id;
            $notifi_data->notifiable_to = $mail->id;
            $notifi_data->data = 'Your Site Manager Send Items Request';
            $notifi_data->save();
        }


        return redirect('manager_view')->with('success','Your RFI send and mailed it to Admin successfully.');
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

    public function update_delivery_date(Request $request)
    {
        $affectedRows = prch_itemwise_requs::where("id",$request->id)->update(["expected_date"=>$request->expected_date]);
        return back();
    }

    public function manager_view_hold_item($id)
    {
        $data = prch_itemwise_requs::with('quantitystored')->where(['prch_rfi_id'=>$id,'manager_status'=>1,'hold_status'=>1])->get();
        $item_numbers = prch_itemwise_requs::with('quantitystored')->where(['prch_rfi_id'=>$id])->pluck('item_no');

        foreach($item_numbers as $stock) {
            $mem[] = item::where('item_number',$stock)->pluck('current_stock');
        }
        return view('level_one.hold_items',compact('data','mem'));
    }
}
