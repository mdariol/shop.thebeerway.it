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
     *
     * @deprecated
     * @see \App\Policy::current()
     */
    public static function getCurrentPolicyName($name)
    {
        return self::current($name);

//        return Policy::where('name', $name)
//            ->where('from_date','<=', today())
//            ->orderBy('from_date','desc')
//            ->first();
    }

    /**
     * Get the current policy.
     *
     * @param  string  $name
     * @return Policy|null
     */
    public static function current(string $name)
    {
        return Policy::where('name', $name)
            ->where('from_date', '<=', today())
            ->orderBy('from_date', 'desc')->first();
    }
}
