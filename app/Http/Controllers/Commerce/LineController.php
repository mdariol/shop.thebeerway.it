<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Line;
use App\Rules\InStock;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Line $line)
    {
        $line->update(request()->validate($this->rules()) + [
            'unit_price' => $line->beer->price->distribution,
            'price' => $request->qty * $line->beer->price->distribution,
        ]);

        if ($request->wantsJson()) {
            return $line;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Line $line
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Line $line)
    {
        $bool = $line->delete();

        if (request()->wantsJson()) {
            return ['deleted' => $bool];
        }
    }

    /**
     * Validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'beer_id' => ['required', 'exists:beers,id'],
            'qty' => ['required', 'min:1', new InStock(request()->beer_id)],
        ];
    }
}
