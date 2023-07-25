<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use Auth;
use App\unitofmeasurement;
use App\Member;
use App\RfiUsers;
use App\RfiManager;
use App\RfiDiscardReason;
use App\SiteName;
use App\Prch_Team;
use App\Prch_Team_Person;
use App\item;
use App\Exports\ExportRFIItems;
use App\Exports\ExportRFIItemsView;
use App\prch_itemwise_requs;
use \App\Mail\SendMailToSadmin;
use \App\Notifications\WelocmeNotification;
use DB;

class RequestForItemAdminController extends Controller
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
                 ->select("prch_rfi_id as id","created_at","manager_id","count","request_date","expected_date","admin_status","manager_approve","admin_approve","purchase_status",DB::raw("string_agg(item_name,',') as item"))
                ->whereIn('team_id',$site_id)
                 ->where(['admin_status'=>1,'dispatch_status'=>0,'manager_approve'=>1,'admin_approve'=>0])
                 ->groupBy('prch_rfi_id','created_at','manager_id','count','expected_date','request_date','admin_status','manager_approve','admin_approve','purchase_status')
                 ->orderBy('created_at', 'desc')->paginate(10);
             // return (count($requested));
        $adminapprove = DB::table('prch_req_itemwise')
                 ->select("prch_rfi_id as id","created_at","manager_id","count","request_date","expected_date","admin_status","manager_approve","admin_approve","purchase_status",DB::raw("string_agg(item_name,',') as item"))
                 ->whereIn('team_id',$site_id)->where(['admin_approve'=>1])
                 ->groupBy('prch_rfi_id','created_at','manager_id','count','expected_date','request_date','admin_status','manager_approve','admin_approve','purchase_status')
                 ->orderBy('created_at', 'desc')->paginate(10);
        
        return view('level_two.view_admin', compact('request_for_items','adminapprove'));
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
        $data = prch_itemwise_requs::where(['prch_rfi_id'=>$id])->get();
        $item_numbers = prch_itemwise_requs::with('quantitystored')->where(['prch_rfi_id'=>$id])->pluck('item_no');

        foreach($item_numbers as $stock) {
            $mem[] = item::where('item_number',$stock)->pluck('current_stock');
        }
        return view('level_two.admin_rfi_approved',compact('data','mem'));
    }

    // Decline Item of RFI
    public function removereqitembyadmin(Request $request)
    {
        $request->validate([
           'dispatch_reason' => 'required',
        ]);

        $data = prch_itemwise_requs::find($request->id);
        
        $data->dispatch_status = 1;
        $data->dispatch_reason = $request->dispatch_reason;

        $data->save();
        
        return redirect()->back()->with('success','Item Removed Successfully');
    }

    // Hold Item of RFI
    public function holdreqitembyadmin(Request $request)
    {
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
        $data = prch_itemwise_requs::where(['prch_rfi_id'=>$id])->get();
        $item_numbers = prch_itemwise_requs::with('quantitystored')->where(['prch_rfi_id'=>$id])->pluck('item_no');

        foreach($item_numbers as $stock) {
            $mem[] = item::where('item_number',$stock)->pluck('current_stock');
        }
        return view('level_two.admin_approval',compact('data','mem'));
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
        $count = count($request->item_name);
        $i = 0;
        while($i < $count){
            if($request->item_name[$i] !=''){
              
                $newdata = array(
                    'm_quantity' => $request->m_quantity[$i],
                    'admin_approve' => 1,
                    'approve' => 1,
                );
            
            prch_itemwise_requs::where(['prch_rfi_id'=>$id,'item_no'=>$request->item_no[$i]])->update($newdata);

            }       
            $i++;
        }
        
        return redirect('admin_view')->with('success','Your RFI Approve successfully.');
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

    public function purchase_reqitem_by_admin(Request $request)
    {
        // return $request;

        $data = prch_itemwise_requs::where('prch_rfi_id',$request->prch_id)->get();
        $count = count($data);
        $i = 0;
        while($i < $count){
            $newdata = array(
                'purchase_status' => 1,
            );
            
            prch_itemwise_requs::where(['prch_rfi_id'=>$request->prch_id])->update($newdata);
            $i++;
        }
        return response()->json($newdata);
    }


    public function export_items_excel($prch_rfi_id)
    {
        $data = prch_itemwise_requs::where(['prch_rfi_id'=>$prch_rfi_id])->get();
        return view('level_two.table',compact('data'));

    }


    public function rfi_items_export(Request $request)
    {
        $values = $request->post('ids');

        // $data = prch_itemwise_requs::select('item_name', 'm_quantity','quantity_unit','description')
        //->whereIn('id',explode(',',$values))->get();

        // echo $data;
        $data = Excel::download(new ExportRFIItemsView($values),'Items.xlsx');
        return response()->json($data);

        // $data = Excel::download(new ExportRFIItems($values),'Items.xlsx');
        // return response()->json($data);
        

       
        // return response()->json(['item_name' => $data]);
        // echo $data;
        // return response()->json([
        //     'data' => $data,
        // ]);

        // $data = prch_itemwise_requs::where('id',$query)->get();

        // if($data->count() > 0)
        // {
        //     dd($data);
        //     foreach($data->toArray() as $key => $value)
        //     {
        //         dd($value);
        //         $ids = DB::select(DB::raw("SELECT nextval('prch_items_id_seq1')"));
        //         $l_id = $ids[0]->nextval+1;
        //         $categories = item_category::where('name', $value['category'])->first();                   
                 
        //         $data['item_number'] = $order_id;
        //         $insert_data[] = array(
        //             'item_number' => $order_id,
        //             'part_number' =>$value['part_number'],            
        //             'item_name' => $value['item_name'],
                   
        //             'consumable' => $value['consumable'],  
        //         );
        //     }
        // }




        // $output = '';
        // foreach($datas as $row)
        // {
        // $output .= ''.$row->item_name .''.$row->m_quantity .''.$row->quantity_unit.''.$row->description.'';

        // }
        // $output .= '';



        // // echo $output;
        
        // return response()->json($output);
    }

    // public function rfi_items_export(Request $request)
    // {
    //     // return $request;

    //     $excel = Excel::download(new ExportRFIItems,'Items.xlsx');
    //     return back();
    //     // return response()->json(['success'=>"Products Deleted successfully."]);
    // }


    public function FunctionName($value='')
    {
        // code...
    }

}
