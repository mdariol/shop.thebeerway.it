<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Policy;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * Validation rules.
     */
    const RULES = [
        'billing_profile_id' => ['required', 'exists:billing_profiles,id'],
        'shipping_address_id' => ['required', 'exists:shipping_addresses,id'],
        'policy_id' => ['required', 'exists:policies,id'],
    ];

    /**
     * CheckoutController constructor.
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Display checkout form.
     *
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function show()
    {
        $this->validateCart();

        return view('cart.checkout')->with([
            'cart' => cart(),
            'billingProfiles' => auth()->user()->billing_profiles()
                ->where('state', 'approved')->get(),
            'billingProfile' => auth()->user()->billing_profiles->first(),
            'policy' => Policy::current('vendita'),
        ]);
    }

    /**
     * Process checkout steps.
     *
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function process()
    {
        $this->validateCart();
        $cart = cart();

        $cart->update(request()->validate(self::RULES));
        $cart->state_machine->apply('send');

        return redirect()->route('orders.show', ['order' => $cart->id]);
    }

    /**
     * Whether the cart can be an order or not.
     *
     * @return bool
     * @throws ValidationException
     */
    protected function validateCart()
    {
        $cart = cart();

        if ($cart->isEmpty()) {
            throw new ValidationException(
                null,
                redirect()->route('cart.show')->with([
                    'invalid_cart' => 'Non puoi acquistare un carrello vuoto...',
                ])
            );
        }

        if ( ! $cart->checkStock()) {
            throw new ValidationException(
                null,
                redirect()->route('cart.show')->with([
                    'invalid_cart' => 'Una o più birre non sono disponibili.'
                ])
            );
        }

        return true;
    }
}
