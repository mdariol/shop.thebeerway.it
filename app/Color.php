<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name'];
    public function colors()
    {
        return $this->hasMany(Beer::class);
    }
}
