<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieControllerTest extends TestCase
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
    public function test_can_list_movies()
    {
        Movie::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/movies');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
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
    public function test_can_create_movie()
    {
        $data = [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'director' => $this->faker->name,
            'release_year' => $this->faker->year,
            'genre' => $this->faker->word,
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/movies', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'description',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('movies', $data);
    }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function test_can_show_movie()
    {
        $movie = Movie::factory()->create();

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/movies/{$movie->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'description',
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
    public function test_can_update_movie()
    {
        $movie = Movie::factory()->create([
            'title' => 'Original Title',
            'description' => 'Original Description',
        ]);

        $data = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'director' => 'Updated Director',
            'release_year' => '2022',
            'genre' => 'Updated Genre',
        ];

        $response = $this->actingAs($this->user)
                        ->putJson("/api/v1/movies/{$movie->id}", $data);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'message',
                    'data' => [
                        'id',
                        'title',
                        'description',
                        'created_at',
                        'updated_at',
                    ],
                ]);

        // Assert the movie was updated
        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'director' => 'Updated Director',
            'release_year' => '2022',
            'genre' => 'Updated Genre',
        ]);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_can_delete_movie()
    {
        $movie = Movie::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/v1/movies/{$movie->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Movie deleted successfully',
            ]);

        $this->assertSoftDeleted('movies', [
            'id' => $movie->id,
        ]);
    }

    /**
     * Test unauthorized access to index method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_index()
    {
        $response = $this->getJson('/api/v1/movies');

        $response->assertStatus(401);
    }

    /**
     * Test unauthorized access to store method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_store()
    {
        $data = [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
        ];

        $response = $this->postJson('/api/v1/movies', $data);

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
                         ->postJson('/api/v1/movies', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'description']);
    }

    /**
     * Test unauthorized access to show method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_show()
    {
        $movie = Movie::factory()->create();

        $response = $this->getJson("/api/v1/movies/{$movie->id}");

        $response->assertStatus(401);
    }

    /**
     * Test unauthorized access to update method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_update()
    {
        $movie = Movie::factory()->create();

        $data = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ];

        $response = $this->putJson("/api/v1/movies/{$movie->id}", $data);

        $response->assertStatus(401);
    }

    /**
     * Test unauthorized access to destroy method.
     *
     * @return void
     */
    public function test_unauthorized_access_to_destroy()
    {
        $movie = Movie::factory()->create();

        $response = $this->deleteJson("/api/v1/movies/{$movie->id}");

        $response->assertStatus(401);
    }
}
