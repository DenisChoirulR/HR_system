<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The demo object instance.
     *
     * @var Name
     */
    public $data_admin;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data_admin)
    {
        $this->data_admin = $data_admin;
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
        ->subject('New Member Info')
        ->view('emails.info_new_member');
    }
}
