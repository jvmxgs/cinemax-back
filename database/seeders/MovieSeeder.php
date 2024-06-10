<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::factory()->count(50)->create();

        $this->command->info('Created sample movies.');

        $this->command->info('Adding images to movies...');

        if (!Storage::exists('public/posters')) {
            Storage::makeDirectory('public/posters');
        }

        $movies->each(function (Movie $movie) {
            $randomImageUrl = config('services.random_image.url');
            $response = Http::get($randomImageUrl);
            $tempImagePath = storage_path('app/public/posters/' . $movie->id . '.jpg');

            file_put_contents($tempImagePath, $response->body());

            $movie->addMedia($tempImagePath)->toMediaCollection('poster', 'public');
        });
    }
}
