<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|nullable|string',
            'director' => 'required|nullable|string|max:255',
            'release_year' => 'required|nullable|integer|min:1800|max:' . (date('Y') + 1),
            'genre' => 'required|nullable|string|max:255',
            'image' => 'required|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
