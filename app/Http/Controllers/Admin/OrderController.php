<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;

class OrderController extends Controller
{
    const RULES = [
        'billing_profile_id' => ['required', 'exists:billing_profiles,id'],
        'shipping_address_id' => ['required', 'exists:shipping_addresses,id'],
        'delivery_note' => 'nullable',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.admin.index')->with([
            'orders' => Order::queryFilter()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( ! request()->filled('user')) {
            return view('order.admin.choice');
        }

        $user = User::findOrFail(request()->user);

        return view('order.admin.create')->with([
            'user' => $user,
            'billingProfiles' => $user->billing_profiles()
                ->where('state', 'approved')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }
}
