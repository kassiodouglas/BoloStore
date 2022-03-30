<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $cakes = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cakes)
    {
        $this->cakes = $cakes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('bolo.store@email.com')->markdown('emails.interested')->with('cakes',$this->cakes);
    }
}
