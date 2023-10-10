<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DefaultMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $content, User $user)
    {
        $this->content = $content;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.default-mail', [
            'content' => $this->content,
            'user' => $this->user
        ]);
    }
}
