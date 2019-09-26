<?php

namespace App\Traits;

use Sebdesign\SM\Facade;

trait HasState
{
    /**
     * Get related state machine.
     *
     * @return mixed
     */
    public function getStateMachineAttribute()
    {
        return Facade::get($this, self::WORKFLOW);
    }
}
