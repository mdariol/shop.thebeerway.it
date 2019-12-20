<?php

namespace Tests\Feature;

use App\Beer;
use App\Order;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_publican_can_add_available_beer_to_cart()
    {
        $beer = factory(Beer::class)->state('available')->create();

        auth()->login($this->user);

        $this->post(route('cart.add'), [
            'beer_id' => $beer->id,
            'quantity' => 1,
        ]);

        $this->assertDatabaseHas('lines', [
            'order_id' => cart()->id,
            'beer_id' => $beer->id,
        ]);
    }

    /** @test */
    public function a_publican_cannot_add_unavailable_beer_to_cart()
    {
        $beer = factory(Beer::class)->state('unavailable')->create();

        auth()->login($this->user);

        $this->post(route('cart.add'), [
            'beer_id' => $beer->id,
            'quantity' => 1,
        ]);

        $this->assertDatabaseMissing('lines', [
            'order_id' => cart()->id,
            'beer_id' => $beer->id,
        ]);
    }

    /** @test */
    public function sending_an_order_should_decrease_available_beers()
    {
        $cart = factory(Order::class)->states('cart')->create();
        $beer = factory(Beer::class)->state('available')->create();

        $cart->add($beer);
        $cart->state_machine->apply('send');

        $this->assertEquals(4, $beer->available);
    }

//    /** @test */
    public function canceling_an_order_should_increase_available_beers()
    {
        // TODO: Improve orders factory().

        $order = factory(Order::class)->create();
        // We're using unavailable beer to simulate order's sent state.
        $beer = factory(Beer::class)->state('unavailable')->create();

        $order->add($beer);
        $order->state_machine->apply('cancel');

        $this->assertEquals(1, $beer->available);
    }

    /** @test */
    public function shipping_an_order_should_decrease_in_stock_beers()
    {
        $order = factory(Order::class)->create();
        // We're using unavailable beer to simulate order's sent state.
        $beer = factory(Beer::class)->state('unavailable')->create();

        $order->add($beer);
        $order->state_machine->apply('ship');

        $this->assertEquals(4, $beer->stock);
    }

    /** @test */
    public function a_sent_order_should_have_movements()
    {
        $cart = factory(Order::class)->state('cart')->create();
        $beer = factory(Beer::class)->state('available')->create();

        $cart->add($beer);
        $cart->state_machine->apply('send');

        $this->assertDatabaseHas('movements', [
            'lot_id' => $beer->lots->first()->id,
            'line_id' => $cart->lines->first()->id,
        ]);
    }

    /** @test */
    public function canceling_an_order_should_revert_movements()
    {
        $cart = factory(Order::class)->state('cart')->create();
        $beer = factory(Beer::class)->state('available')->create();

        $cart->add($beer);
        $cart->state_machine->apply('send');

        $cart->state_machine->apply('cancel');

        $movement = $cart->movements->first();

        $this->assertTrue($movement->reverted());
    }
}
