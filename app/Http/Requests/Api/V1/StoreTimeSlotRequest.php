<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\UniqueTimeSlot;
use App\Rules\ValidTimeSlot;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimeSlotRequest extends FormRequest
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
        if (is_numeric($this->movie_id)) {
            $this->merge([
                'movie_id' => $this->movie_id
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
        return [
            'start_time' => ['required', 'date_format:H:i:s', new ValidTimeSlot, new UniqueTimeSlot],
            'is_active' => 'required|boolean',
            'movie_id' => 'exists:movies,id,deleted_at,NULL',
        ];
    }
}
