<?php

namespace App\Mail;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class inicioSesion extends Mailable
{
   use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
      public function __construct()
      {
         
      }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from(Auth::user()->email)->markdown('emails.login.sesion');
    }
}
