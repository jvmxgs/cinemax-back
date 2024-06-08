<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'director' => $this->faker->name,
            'release_year' => $this->faker->year,
            'genre' => $this->faker->word,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Movie $movie) {
            if (!Storage::exists('public')) {
                Storage::makeDirectory('public');
            }

            $movie->addMedia(UploadedFile::fake()->image('poster.jpg'))->toMediaCollection('poster', 'public');
        });
    }
}
