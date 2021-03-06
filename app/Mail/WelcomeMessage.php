<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class WelcomeMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     *   The recipient.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = Password::createToken($this->user);
        $baseURL = env('APP_URL', '');
        $url = URL::to("{$baseURL}/reset-password/{$this->user->email}/{$token}");
        return $this
            ->subject("Welcome to Allbiz Timesheet")
            ->markdown('mail.welcome', ['url' => $url]);
    }
}
