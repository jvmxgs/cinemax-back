<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\UniqueTimeSlot;
use App\Rules\ValidTimeSlot;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeSlotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $movie_id = intval($this->movie_id);
        info($this->movie_id);
        info($movie_id);

        if (!empty($movie_id)) {
            $this->merge([
                'movie_id' => $movie_id
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $timeSlotId = $this->route('time_slot');

        return [
            'start_time' => ['date_format:H:i:s', new ValidTimeSlot, new UniqueTimeSlot($timeSlotId)],
            'is_active' => 'boolean',
            'movie_id' => 'nullable|exists:movies,id,deleted_at,NULL',
        ];
    }
}
