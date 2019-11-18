<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionUser extends Model
{

    protected $fillable = [
        'promotion_id', 'user_id',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
