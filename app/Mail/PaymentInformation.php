<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Invoice;
use App\GRR_Payment;
use App\User;
use PDF;

class PaymentInformation extends Mailable
{
    use Queueable, SerializesModels;
    // public $details;
    // public $id;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct($details,$id)
    // {
    // 	$this->details = $details;
    //     $this->id = $id;
    // }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('payment.payment_mail');
        // $data = Purchase_order::where('id',$this->id)->first(); 
        // $items = Purchase_order_detail::where('item_id',$this->id)->get();       
         
        // $pdf = PDF::loadView('Generate_Purchase_Order.download_purchase_order_receipt',compact('data','items'));
        // return $this->view('payment.payment_mail')->attachData($pdf->output(), "PurchaseOrder.pdf")->with("details");
        
    }
}