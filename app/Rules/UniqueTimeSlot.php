<?php

namespace App\Rules;

use App\Models\TimeSlot;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueTimeSlot implements ValidationRule
{
    protected $interval;

    public function __construct($interval = 59)
    {
        $this->interval = $interval;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $startTime = Carbon::createFromFormat('H:i:s', $value);

        $conflictingTimeSlot = TimeSlot::query()
            ->where('start_time', '>=', $startTime->copy()->subMinutes($this->interval)->format('H:i:s'))
            ->where('start_time', '<=', $startTime->copy()->addMinutes($this->interval)->format('H:i:s'))
            ->exists();

        if ($conflictingTimeSlot) {
            $fail('The :attribute conflicts with an existing time slot or does not respect the minimum interval of 59 mins.');
        }
    }
}
