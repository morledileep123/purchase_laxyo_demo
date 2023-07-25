<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Send_quotation;
use App\Send_quotation_Vendor_detail;
use App\Item_quotation_data;
use PDF;

class SendQuotationToVendors extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $id;
    public $resever;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$id,$resever)
    {
    	$this->details = $details;
        $this->id = $id;
        $this->resever = $resever;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = Send_quotation::where('id',$this->id)->first(); 
        $items = Item_quotation_data::where('item_id',$this->id)->get();       
        $vendors_data = Send_quotation_Vendor_detail::where('item_id',$this->id)->first();

        $pdf = PDF::loadView('Quotation_Vendor.download_purchase_order_receipt',compact('data','items','vendors_data'));
        return $this->view('Generate_Purchase_Order.pomail')->attachData($pdf->output(), "Quotation.pdf")->with("details");
    }
}