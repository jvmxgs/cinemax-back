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
        $startTime = Carbon::createFromTime(9, 0, 0); // 9:00 AM
        $endTime = Carbon::createFromTime(23, 0, 0);  // 11:00 PM

        $faker = Faker::create();
        $moviesCount = Movie::count();

        while ($startTime->lessThan($endTime)) {
            TimeSlot::factory()->create([
                'start_time' => $startTime->format('H:i:00'),
                'movie_id' => $faker->randomElement($moviesCount ? Movie::pluck('id')->toArray() : [null])
            ]);

            $interval = rand(10, 15) * 10;
            $startTime->addMinutes($interval);
        }
    }
}
