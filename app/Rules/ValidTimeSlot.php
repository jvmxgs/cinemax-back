<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidTimeSlot implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $time = Carbon::createFromFormat('H:i:s', $value);

        $startLimit = Carbon::createFromTime(9, 0, 0);  // 9:00 AM
        $endLimit = Carbon::createFromTime(23, 00, 00); // 11:00 PM

        if (!$time->between($startLimit, $endLimit)) {
            $fail('The :attribute must be between 09:00:00 and 23:00:00');
        }
    }
}
