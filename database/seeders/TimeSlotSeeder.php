<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $startTime = Carbon::createFromTime(9, 0, 0); // 9:00 AM
        $endTime = Carbon::createFromTime(23, 0, 0);  // 11:00 PM

        $movies = Movie::all();

        while ($startTime->lessThan($endTime)) {
            TimeSlot::factory()->create([
                'start_time' => $startTime->format('H:i:00'),
                'movie_id' => $faker->randomElement(Movie::pluck('id')->toArray()),
            ]);

            $interval = rand(10, 15) * 10;
            $startTime->addMinutes($interval);
        }
    }
}
