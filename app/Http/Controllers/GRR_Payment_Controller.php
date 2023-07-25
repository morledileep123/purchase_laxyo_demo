<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\GRR_Payment;
use App\User;
use Carbon\Carbon;
use Auth;
Use Mail;
use \App\Mail\PaymentInformation;

class GRR_Payment_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data = Invoice::where('id',$id)->first(); 
        return view('payment.grr_create_payment',compact('data'));
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
        $request->validate([
            'amount_paid' => 'required',
            'tds' => 'required',
        ]);

        $vender_person_email = 'sourabh@laxyo.org';

        $details = array(
            'invoice_no' => $request->invoice_no,
        );
        
        if($vender_person_email != null){
            \Mail::to($vender_person_email)->send(new PaymentInformation($details));
        }
        
        return back();
        
        $datas = Invoice::where('id',$request->id)->update(['acountent_approve'=>1,'approve'=>1 ]);

        $user_id = Auth::user()->id; 
        $payment_date = Carbon::today();

        $data = new GRR_Payment;

        $data->item_id = $request->id;
        $data->user_id = $user_id;
        $data->payment_date = $payment_date;
        $data->vendore_details = $request->vendore_details;
        $data->invoice_no = $request->invoice_no;
        $data->invoice_date = $request->invoice_date;
        $data->invoice_amount = $request->invoice_amount;
        $data->po_no = $request->po_no;
        $data->po_date = $request->po_date;
        $data->amount_paid = $request->amount_paid;
        $data->gst = $request->gst;
        $data->tds = $request->tds;
        $data->balance_paid = $request->balance_paid;

        $data->save();

        return redirect('accountant_grr_index')->with('success', 'Payment successfully.');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $id;
        $data = GRR_Payment::where('item_id',$id)->first(); 
        $user = User::find($data->user_id);
        $user_name = $user->name;
        return view('payment.grr_show_payment',compact('data','user_name'));
    }

    // all role show Payment approve GRR View
    public function GGRPaymentShow($id)
    {
      $data = GRR_Payment::where('item_id',$id)->first(); 
      $user = User::find($data->user_id);
      $user_name = $user->name;
      return view('payment.grr_show_payment',compact('data','user_name'));
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
