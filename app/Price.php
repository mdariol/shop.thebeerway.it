<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public function beer()
    {
        return $this->hasOne(Beer::class);
    }
}
