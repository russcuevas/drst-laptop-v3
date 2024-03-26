<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fullname;
    public $resetLink;

    /**
     * Create a new message instance.
     *
     * @param string $fullname
     * @param string $resetLink
     */
    public function __construct($fullname, $resetLink)
    {
        $this->fullname = $fullname;
        $this->resetLink = $resetLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('auth.reset_password')
            ->subject('Reset Password')
            ->with([
                'fullname' => $this->fullname,
                'resetLink' => $this->resetLink,
            ]);
    }
}
