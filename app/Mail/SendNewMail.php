<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewMail extends Mailable
{
    use Queueable, SerializesModels;
    public $lead;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lead)
    {
        
        $this->lead = $lead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    // {
    //     $address = 'janeexampexample@example.com';
    //     $subject = 'This is a demo!';
    //     $name = 'Jane Doe';

    //     return $this->view('emails.email')
    //                 ->from($address, $name)
    //                 ->cc($address, $name)
    //                 ->bcc($address, $name)
    //                 ->replyTo('emmanuel.paris@icloud.com', $name)
    //                 ->subject($subject);
    //                 ->with([ 'test_message' => $this->data['message'] ]);
    // }
    {
        return $this->view('emails.email');
    }

}
