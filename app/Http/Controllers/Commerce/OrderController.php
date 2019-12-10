<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Order;
use App\Brewery;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::queryFilter()
            ->join('billing_profile_has_users', 'orders.billing_profile_id', '=', 'billing_profile_has_users.billing_profile_id' )
            ->where('billing_profile_has_users.user_id', '=', auth()->id() )
            ->get();

        return view('order.index')->with([
            'orders' => $orders,
            'breweries' => Brewery::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('order.show')->with(['order' => $order]);
    }

    /**
     * Apply transition to specified resource.
     *
     * @param  \App\Order  $order
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function transition(Order $order)
    {
        $this->authorize('transition', $order);

        $order->state_machine->apply(request()->transition);
        $order->save();

        return back();
    }
}
