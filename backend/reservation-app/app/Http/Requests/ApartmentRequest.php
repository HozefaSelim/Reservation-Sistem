<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'rating' => 'nullable|integer|min:0|max:5',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'available' => 'boolean',
            'user_id' => 'required|exists:users,id',
            'images' => 'nullable|array',  // Array of images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',  // Each file must be an image
        ];
    }
}
