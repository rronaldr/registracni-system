<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomHtmlMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public $html;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $html)
    {
        $this->user = $user;
        $this->html = $html;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.html.mail.blade.php');
    }
}
