<?php

namespace App\Rules;

use App\Models\Showtime;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEndDateRange implements ValidationRule
{
    protected $showtimeId;

    public function __construct($showtimeId)
    {
        $this->showtimeId = $showtimeId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $showtime = Showtime::find($this->showtimeId);

        if (!$showtime) {
            return;
        }

        if (strtotime($value) < strtotime($showtime->start_date)) {
            $fail('The :attribute must be a date after or equal to the start date:' . $showtime->start_date);
        }
    }
}
