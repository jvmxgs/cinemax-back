<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Showtime;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ShowTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $moviesCount = Movie::count();
        $timeSlots = TimeSlot::all();

        if ($moviesCount == 0) {
            return;
        }

        $timeSlots->each(function ($timeSlot) use ($faker, $moviesCount) {
            Showtime::factory()->create([
                'time_slot_id' => $timeSlot->id,
                'movie_id' => $faker->randomElement(Movie::pluck('id')->toArray()),
            ]);
        });
    }
}
