<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['action', 'quantity', 'lot_id', 'agent_id'];

    /**
     * Related lot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    /**
     * Related agent. The user who performed the movement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo(User::class);
    }
}
