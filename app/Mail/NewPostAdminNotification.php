<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    // Dichiaro una proprietà chiamata $new_post
    protected $new_post;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    //  Qui dico che quando la mail è mandata ha bisogno di un construct
    public function __construct($_new_post)
    {   
        // Qui passo il construct ottenuto nel controller alla proprietà mail $new_post
        // in modo che ora la contenga e siano sempre collegati. In pratica in questo modo
        // mi vado a prendere il post appena creato di modo da leggerne le proprietà (colonne)
        // e stamparmele nella mail
        $this->new_post = $_new_post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        // L'array che passo alla view della mail per stampare i dati del nuovo post
        $data = [   
            'new_post' => $this->new_post
        ];

        return $this->view('emails.new-post-admin-notification', $data);
    }
}
