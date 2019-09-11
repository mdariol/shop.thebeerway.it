<?php

namespace App\Traits;

use SM\Factory\Factory;

trait HasState
{
    /**
     * Get related state machine.
     *
     * @return mixed
     */
    public function getStateMachineAttribute()
    {
        return resolve(Factory::class)->get($this, self::WORKFLOW);
    }
}
