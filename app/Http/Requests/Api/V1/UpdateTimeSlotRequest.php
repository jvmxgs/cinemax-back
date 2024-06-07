<?php

namespace App\Http\Requests\Api\V1;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_time' => ['date_format:H:i:s', new ValidTimeSlot],
            'is_active' => 'boolean',
            'movie_id' => 'exists:movies,id',
        ];
    }
}
