<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function styles()
    {
        return $this->hasMany(Style::class);
    }
}
