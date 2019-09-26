<?php

namespace App;


class Cart
{
    public $order_id = null;
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $deliverynote = null;
    public $company_id = null;
    public $shipping_address_id = null;

    public function __construct($oldCart)
    {
        if ($oldCart){

            $this->order_id = $oldCart->order_id;
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->deliverynote = $oldCart->deliverynote;
            $this->company_id = $oldCart->company_id;
            $this->shipping_address_id = $oldCart->shipping_address_id;
        }
    }

    public function add($item, $id){

        $storedItem = ['qty' => 0, 'price' => $item->price->distribution, 'item' => $item];

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