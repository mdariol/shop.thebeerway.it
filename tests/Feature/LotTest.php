<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
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

        $this->lot = factory(\App\Lot::class)->create();
    }

    /** @test */
    public function unauthorized_user_cannot_view_lots()
    {
        $responses = collect([]);

        $responses->push($this->get(route('admin.lots.index')));
        $responses->push($this->get(route('admin.lots.show', ['lot' => $this->lot])));

        $responses->each(function ($response) {
            $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        });
    }

    /** @test */
    public function unauthorized_user_cannot_create_lots()
    {
        $responses = collect([]);

        $responses->push($this->get(route('admin.lots.create')));
        $responses->push($this->post(route('admin.lots.store')));

        $responses->each(function ($response) {
            $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        });
    }

    /** @test */
    public function unauthorized_user_cannot_edit_lots()
    {
        $responses = collect([]);

        $responses->push($this->get(route('admin.lots.edit', ['lot' => $this->lot])));
        $responses->push($this->patch(route('admin.lots.update', ['lot' => $this->lot])));

        $responses->each(function ($response) {
            $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        });
    }

    /** @test */
    public function unauthorized_user_cannot_delete_lots()
    {
        $responses = collect([]);

        $responses->push($this->get(route('admin.lots.delete', ['lot' => $this->lot])));
        $responses->push($this->delete(route('admin.lots.destroy', ['lot' => $this->lot])));

        $responses->each(function ($response) {
            $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        });
    }
}
