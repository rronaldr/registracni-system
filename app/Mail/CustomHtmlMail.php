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
    public function __construct(string $subject, User $user, string $html)
    {
        $this->subject = $subject;
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
