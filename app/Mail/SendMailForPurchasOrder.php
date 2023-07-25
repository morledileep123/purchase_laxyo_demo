<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToVendor extends Mailable
{
    use Queueable, SerializesModels;
    public $person_email;
    public $company_name;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($person_email,$company_name)
    {
    	 $this->person_email = $person_email;
         $this->company_name = $company_name;

    }


    /*attach('/home/mohini5/Desktop/', [
	      'as' => 'rfi_quotation16-Jan-2020.pdf',
	      'mime' => 'application/pdf',
	  ]);*/


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail From Vendor')->view('Transaction.vendormail');

    }
}
