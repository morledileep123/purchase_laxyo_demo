<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $uname;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($uname)
    {

    	 $this->uname = $uname;

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
        return $this->subject('Mail From Purchase')->view('request_for_item.adminmail');
    }
}
