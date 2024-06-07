<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\Showtime;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowtimeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    /**
     * Set up the environment for each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_can_list_showtimes()
    {
        Showtime::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/showtimes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'movie',
                        'time_slot',
                        'start_date',
                        'end_date',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_can_create_showtime()
    {
        $movie = Movie::factory()->create();
        $timeSlot = TimeSlot::factory()->create();

        $data = [
            'movie_id' => $movie->id,
            'time_slot_id' => $timeSlot->id,
            'start_date' => $this->faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 week')->format('Y-m-d')
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/showtimes', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'movie',
                    'time_slot',
                    'start_date',
                    'end_date',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('showtimes', $data);
    }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function test_can_show_showtime()
    {
        $showtime = Showtime::factory()->create();

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/showtimes/{$showtime->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'movie',
                    'time_slot',
                    'start_date',
                    'end_date',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_can_update_showtime()
    {
        $movie = Movie::factory()->create();

        $showtime = Showtime::factory()->create();

        $data = [
           'movie_id' => $movie->id
        ];

        $response = $this->actingAs($this->user)
                        ->putJson("/api/v1/showtimes/{$showtime->id}", $data);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'message',
                    'data' => [
                        'id',
                        'movie',
                        'time_slot',
                        'start_date',
                        'end_date',
                        'created_at',
                        'updated_at',
                    ],
                ]);

        $this->assertDatabaseHas('showtimes', [
            'id' => $showtime->id,
            'movie_id' => $movie->id
        ]);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_can_delete_showtime()
    {
        $showtime = Showtime::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/v1/showtimes/{$showtime->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Showtime deleted successfully',
            ]);

        $this->assertSoftDeleted('showtimes', [
            'id' => $showtime->id,
        ]);
    }

    /**
     * Test unauthorized access to index method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_index()
    {
        $response = $this->getJson('/api/v1/showtimes');

        $response->assertStatus(401);
    }

    /**
     * Test unauthorized access to store method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_store()
    {
        $response = $this->postJson('/api/v1/showtimes', []);

        $response->assertStatus(401);
    }

    /**
     * Test validation error on store method.
     *
     * @return void
     */
    public function test_validation_error_on_store()
    {
        $response = $this->actingAs($this->user)
                         ->postJson('/api/v1/showtimes', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['movie_id', 'time_slot_id', 'start_date', 'end_date']);
    }

    /**
     * Test unauthorized access to show method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_show()
    {
        $showtime = Showtime::factory()->create();

        $response = $this->getJson("/api/v1/showtimes/{$showtime->id}");

        $response->assertStatus(401);
    }

    /**
     * Test unauthorized access to update method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_update()
    {
        $showtime = Showtime::factory()->create();
        $movie = Movie::factory()->create();

        $data = [
            'movie_id' => $movie->id,
        ];

        $response = $this->putJson("/api/v1/showtimes/{$showtime->id}", $data);

        $response->assertStatus(401);
    }

    /**
     * Test unauthorized access to destroy method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_destroy()
    {
        $showtime = Showtime::factory()->create();

        $response = $this->deleteJson("/api/v1/showtimes/{$showtime->id}");

        $response->assertStatus(401);
    }
}
