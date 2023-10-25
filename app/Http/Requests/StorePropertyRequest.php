<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','min:3','max:20'],
            'details' => ['required', 'min:10', 'max:255'],
            'type' => ['required', 'in:residential,commercial'],
            'size*' => ['nullable','required_if:type,residential'],
            'amenity_id.*' => ['required','exists:amenities,id'],
            'address' => ['required', 'min:5', 'max:255'],
            'brochure' => ['required','mimes:PDF,pdf'],
            'images*' => ['required'],
        ];
    }
}
