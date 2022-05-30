<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class YourAccountIsActiveMail extends Mailable
{
     use Queueable, SerializesModels;
    /**
     * The demo object instance.
     *
     * @var Name
     */
    public $data_user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data_user)
    {
        $this->data_user = $data_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->cc('info@medicalogy.com')
        ->subject('Active Account')
        ->view('emails.your_account_is_active');
    }
}
