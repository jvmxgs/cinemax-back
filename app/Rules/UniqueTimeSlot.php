<?php

namespace App\Rules;

use App\Models\TimeSlot;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueTimeSlot implements ValidationRule
{
    protected $timeSlotId;
    protected $interval;

    public function __construct($timeSlotId = null, $interval = 20)
    {
        $this->interval = $interval;
        $this->timeSlotId = $timeSlotId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parsedValue = date('H:i:s', strtotime($value));

        $startTime = Carbon::createFromFormat('H:i:s', $parsedValue);

        $conflictingTimeSlot = TimeSlot::query()
            ->when($this->timeSlotId, function ($query) {
                $query->whereNot('id', $this->timeSlotId);
            })
            ->where('start_time', '>=', $startTime->copy()->subMinutes($this->interval)->format('H:i:s'))
            ->where('start_time', '<=', $startTime->copy()->addMinutes($this->interval)->format('H:i:s'))
            ->exists();

        if ($conflictingTimeSlot) {
            $fail('The :attribute conflicts with an existing time slot or does not respect the minimum interval of 20 mins.');
        }
    }
}
