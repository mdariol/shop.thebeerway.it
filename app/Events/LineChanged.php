<?php

namespace App\Events;

use App\Line;

class LineChanged
{
    public $line;

    /**
     * LineCreated constructor.
     *
     * @param  Line  $line
     */
    public function __construct(Line $line)
    {
        $this->line = $line;
    }
}
