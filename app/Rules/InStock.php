<?php

namespace App\Rules;

use App\Beer;
use Illuminate\Contracts\Validation\Rule;

class InStock implements Rule
{
    /**
     * @var \App\Beer|int
     */
    protected $beer;

    /**
     * Create a new rule instance.
     *
     * @param \App\Beer|int $beer
     * @return void
     */
    public function __construct($beer)
    {
        if (is_numeric($beer)) $beer = Beer::findOrFail($beer);

        $this->beer = $beer;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value > ($this->beer->stock - $this->beer->requested_stock)) return false;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Il quantitativo di birra richiesto non è a magazzino.';
    }
}
