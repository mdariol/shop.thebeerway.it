<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovementTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Lot  */
    protected $lot;
    /** @var \Illuminate\Support\Collection */
    protected $lots;

    protected function setUp(): void
    {
        parent::setUp();

        $this->lot = factory(\App\Lot::class)->state('available')->create();
        $this->lots = collect([$this->lot]);
    }

    public function binding_lot_should_create_a_movement()
    {
        warehouse()->bind($this->lots);

        $this->assertDatabaseHas('movements', [
            'lot_id' => $this->lot->id,
            'action' => 'bind',
            'quantity' => 1,
        ]);

        warehouse()->unbind($this->lots);

        $this->assertDatabaseHas('movements', [
            'lot_id' => $this->lot->id,
            'action' => 'unbind',
            'quantity' => 1,
        ]);
    }

    /** @test */
    public function loading_lot_should_create_a_movement()
    {
        warehouse()->unload($this->lots);

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

    /** @test */
    public function reverting_movement_should_revert_lot_state()
    {
        $movements = warehouse()->bind($this->lots);

        warehouse()->revert($movements->first());

        $this->assertDatabaseHas('movements', [
            'lot_id' => $this->lot->id,
            'reverted_at' => $movements->first()->reverted_at,
        ]);

        $this->assertDatabaseHas('lots', [
            'id' => $this->lot->id,
            'reserved' => 0,
        ]);
    }
}
