<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class UserVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function __construct(Authenticatable $user)
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
        return $this->subject('Verifica indirizzo email')
            ->markdown('emails.user.verify-email')
            ->with(['url' => $this->verificationUrl()]);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @return string
     */
    protected function verificationUrl()
    {
        return Url::temporarySignedRoute(
          'verification.verify',
          Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
          ['id' => $this->user->getKey()]
        );
    }
}
