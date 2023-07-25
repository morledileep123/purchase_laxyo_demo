<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Purchase_order;
use App\Purchase_order_detail;
use App\Vendor;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vendors = Vendor::all();
        // $svendor = $request->post('query');
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $data = Purchase_order::whereBetween('created_at',[$start_date,$end_date])->where('send_email',1)->get();
        }
        elseif($request->get('vendorCompany')) {
            $data = Purchase_order::where(['send_email'=>1,'vendor_details_company'=>$request->get('vendorCompany')])->latest()->get();
            return response()->json(['data' => $data]);
        }
        else {
            $data = Purchase_order::where('send_email',1)->latest()->get();
        }
        return view('Enquiry.index',compact('data','vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $data = Purchase_order::where(['send_email'=>1,'vendor_details_company'=>$request->query])->latest()->get();
        // return response()->json($data);

        // return $request->query;
        // $vendors = Vendor::all();
        // $data = Purchase_order::where('vendor_details_company',$request->query)->latest()->get();

        // return Response::json($data,$vendors);
        // return view('Enquiry.index',compact('data','vendors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Purchase_order::where(['send_email'=>1,'vendor_details_company'=>$request->query])->latest()->get();
        return response()->json($data);
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
        return view('Enquiry.show',compact('data','items'));
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
