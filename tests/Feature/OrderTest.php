<?php

namespace Tests\Feature;

use App\Beer;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    protected $publican;
    /** @var Beer */
    protected $beer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->beer = factory(Beer::class)->create();
        $this->publican = factory(User::class)->create();

        factory(\App\Price::class)->create(['beer_id' => $this->beer->id]);
    }

    /** @test */
    public function a_publican_can_add_available_beer_to_cart()
    {
        factory(\App\Lot::class)->state('available')
            ->create(['beer_id' => $this->beer->id]);

        auth()->login($this->publican);

        $this->post(route('cart.add'), [
            'beer_id' => $this->beer->id,
            'quantity' => 1,
        ]);

        $this->assertDatabaseHas('lines', [
            'order_id' => cart()->id,
            'beer_id' => $this->beer->id,
        ]);
    }

    /** @test */
    public function a_publican_cannot_add_unavailable_beer_to_cart()
    {
        factory(\App\Lot::class)->state('unavailable')
            ->create(['beer_id' => $this->beer->id]);

        auth()->login($this->publican);

        $this->post(route('cart.add'), [
            'beer_id' => $this->beer->id,
            'quantity' => 1,
        ]);

        $this->assertDatabaseMissing('lines', [
            'order_id' => cart()->id,
            'beer_id' => $this->beer->id,
        ]);
    }

    /** @test */
    public function sending_an_order_should_decrease_available_beers()
    {
        // Create lot with available 5 items.
        factory(\App\Lot::class)->state('available')
            ->create(['beer_id' => $this->beer->id]);

        $cart = factory(\App\Order::class)->state('cart')->create();

        $cart->add($this->beer);
        $cart->state_machine->apply('send');

        $this->assertEquals(4, $this->beer->available);
    }
}
