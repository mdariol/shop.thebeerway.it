<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['action', 'quantity', 'lot_id', 'agent_id', 'reverted_at'];

    protected $dates = ['reverted_at'];

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

    /**
     * Whether the movement has been reverted or not.
     *
     * @return bool
     */
    public function reverted()
    {
        return ! is_null($this->reverted_at);
    }
}
