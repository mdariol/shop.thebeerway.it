<?php

namespace App\Mail;

use App\Company;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Company
     */
    public $company;

    /**
     * Create a new message instance.
     *
     * @param \App\Company $company
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Società riconosciuta!')
            ->markdown('emails.company.approved');
    }
}
