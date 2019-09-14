<?php

namespace App\Events;

use App\Company;

class CompanyApproved
{
    public $company;

    /**
     * Create a new event instance.
     *
     * @param \App\Company $company
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }
}
