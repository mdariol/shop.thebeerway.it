<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovementTest extends TestCase
{
    /** @var \App\Lot  */
    protected $lot;

    protected function setUp(): void
    {
        parent::setUp();

        $this->lot = factory(\App\Lot::class)->state('available')->create();
    }

    public function binding_lot_should_create_a_movement()
    {
        $lots = collect([$this->lot]);

        warehouse()->bind($lots);

        $this->assertDatabaseHas('movements', [
            'lot_id' => $this->lot->id,
            'action' => 'bind',
            'quantity' => 1,
        ]);

        warehouse()->unbind($lots);

        $this->assertDatabaseHas('movements', [
            'lot_id' => $this->lot->id,
            'action' => 'unbind',
            'quantity' => 1,
        ]);
    }

    /** @test */
    public function loading_lot_should_create_a_movement()
    {
        $lots = collect([$this->lot]);

        warehouse()->unload($lots);

        $this->assertDatabaseHas('movements', [
            'lot_id' => $this->lot->id,
            'action' => 'unload',
            'quantity' => 1,
        ]);

        warehouse()->load($this->lot);

        $this->assertDatabaseHas('movements', [
            'lot_id' => $this->lot->id,
            'action' => 'load',
            'quantity' => 1,
        ]);
    }
}
