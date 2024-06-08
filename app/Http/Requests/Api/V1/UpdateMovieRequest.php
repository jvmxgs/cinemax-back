<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
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
            'title' => 'string|max:255',
            'description' => 'string',
            'director' => 'string|max:255',
            'release_year' => 'integer|min:1800|max:' . (date('Y') + 1),
            'genre' => 'string|max:255',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
