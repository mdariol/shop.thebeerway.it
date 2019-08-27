<?php

namespace App;


class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id){
        $storedItem = ['qty' => 0, 'price' => $item->price->distribution, 'item' => $item];
//        dd($item);
        if ($this->items){
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        $storedItem['unit_price'] = $item->price->distribution;
        $storedItem['price'] = $item->price->distribution * $storedItem['qty'];
        $storedItem['beer'] = $item->name;
        $storedItem['brewery'] = $item->getRelation('brewery')->getAttribute('name');
        $storedItem['packaging'] = $item->getRelation('packaging')->getAttribute('name');

        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice+= $item->price->distribution;
    }


}