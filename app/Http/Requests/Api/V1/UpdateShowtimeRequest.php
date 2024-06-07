<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\ValidEndDateRange;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShowtimeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $showtime_id = $this->route('showtime');

        return [
            'movie_id' => 'exists:movies,id',
            'time_slot_id' => 'exists:time_slots,id',
            'start_date' => 'date',
            'end_date' => ['date', 'after_or_equal:start_date', new ValidEndDateRange($showtime_id)],
        ];
    }
}
