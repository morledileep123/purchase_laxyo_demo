<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Purchase_order;
use App\Purchase_order_detail;
use PDF;

class SendPOToVendors extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $id;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$id)
    {
    	$this->details = $details;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = Purchase_order::where('id',$this->id)->first(); 
        $items = Purchase_order_detail::where('item_id',$this->id)->get();       
         
        $pdf = PDF::loadView('Generate_Purchase_Order.download_purchase_order_receipt',compact('data','items'));
        return $this->view('Generate_Purchase_Order.pomail')->attachData($pdf->output(), "PurchaseOrder.pdf")->with("details");
    }
}