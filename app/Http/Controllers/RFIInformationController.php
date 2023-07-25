<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\item;
use App\prch_itemwise_requs;

class RFIInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $request_for_items = DB::table('prch_req_itemwise')
                 ->select("prch_rfi_id as id","created_at","manager_id","user_id","count","site_name","request_date","expected_date","user_send_status","manager_approve","manager_status","admin_status","admin_approve","purchase_status",DB::raw("string_agg(item_name,',') as item"))
                 ->groupBy('prch_rfi_id','created_at','manager_id','user_id','count','site_name','expected_date','request_date','user_send_status','manager_approve','manager_status','admin_status','admin_approve','purchase_status')
                 ->orderBy('created_at','desc')->paginate(4);

        return view('request_for_information.index',compact('request_for_items')); 
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

    public function show($id)
    {
        $item = prch_itemwise_requs::where('prch_rfi_id',$id)->get();
        return view('request_for_information.show',compact('item'));
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
}
