<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactAdminNotification extends Mailable
{
    use Queueable, SerializesModels;


    protected $new_contact_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($new_contact_data)
    {
        $this->new_contact_data = $new_contact_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $data = [
            'new_contact_data'=> $this->new_contact_data
        ];

        return $this->view('emails.new-contact-admin-notification', $data);
    }
}
