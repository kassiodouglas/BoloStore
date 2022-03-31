<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $listCakes = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($listCakes)
    {
        $this->listCakes = $listCakes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( config('mail.from.address') )->markdown('emails.interested')->with('cakes',$this->listCakes);
    }
}
