<?php

namespace Tests\Feature\Http\Controllers\Api\Mobile;

use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Mobile\SessionController
 */
class SessionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $sessions = Session::factory()->count(3)->create();

        $response = $this->get(route('session.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\Mobile\SessionController::class,
            'store',
            \App\Http\Requests\Api\Mobile\SessionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $type = $this->faker->word;
        $seats_count = $this->faker->numberBetween(-10000, 10000);
        $start_date = $this->faker->date();
        $start_time = $this->faker->time();

        $response = $this->post(route('session.store'), [
            'type' => $type,
            'seats_count' => $seats_count,
            'start_date' => $start_date,
            'start_time' => $start_time,
        ]);

        $sessions = Session::query()
            ->where('type', $type)
            ->where('seats_count', $seats_count)
            ->where('start_date', $start_date)
            ->where('start_time', $start_time)
            ->get();
        $this->assertCount(1, $sessions);
        $session = $sessions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $session = Session::factory()->create();

        $response = $this->get(route('session.show', $session));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\Mobile\SessionController::class,
            'update',
            \App\Http\Requests\Api\Mobile\SessionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $session = Session::factory()->create();
        $type = $this->faker->word;
        $seats_count = $this->faker->numberBetween(-10000, 10000);
        $start_date = $this->faker->date();
        $start_time = $this->faker->time();

        $response = $this->put(route('session.update', $session), [
            'type' => $type,
            'seats_count' => $seats_count,
            'start_date' => $start_date,
            'start_time' => $start_time,
        ]);

        $session->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($type, $session->type);
        $this->assertEquals($seats_count, $session->seats_count);
        $this->assertEquals(Carbon::parse($start_date), $session->start_date);
        $this->assertEquals($start_time, $session->start_time);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $session = Session::factory()->create();

        $response = $this->delete(route('session.destroy', $session));

        $response->assertNoContent();

        $this->assertSoftDeleted($session);
    }
}
