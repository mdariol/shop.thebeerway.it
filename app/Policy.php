<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    const POLICYNAME = [
        'selling' => 'vendita',
        'privacy' => 'riservatezza'
    ];

    protected $fillable = ['name','content','from_date'];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    /**
     * get current policy name.
     *
     * @return policy
     */
    public static function getCurrentPolicyName($name)
    {
        return Policy::where('name', $name)
            ->where('from_date','<=', today())
            ->orderBy('from_date','desc')
            ->first();
    }

}
