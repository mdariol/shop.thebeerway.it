<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'name', 'discount',
        'from_date', 'to_date', 'priority',
    ];


    //
}
