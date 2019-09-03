<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\PurchaseordersScope;


class Purchaseorder extends Model
{
    protected $fillable = ['date','number','brewery_id'];
    //
    protected $with = ['brewery'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PurchaseordersScope);
    }



    public function brewery()
    {
        return $this->belongsTo(Brewery::class);
    }


}
