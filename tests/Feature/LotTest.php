<?php

namespace Tests\Feature;

use App\Lot;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LotTest extends TestCase
{
    use RefreshDatabase;

    /** @var Lot */
    protected $lot;

    protected function setUp(): void
    {
        parent::setUp();

        $this->lot = factory(Lot::class)->create([
            'stock' => 5,
            'reserved' => 7,
        ]);
    }

    /** @test */
    public function a_lot_can_be_unavailable()
    {
        $this->assertFalse($this->lot->isAvailable());
    }
}
