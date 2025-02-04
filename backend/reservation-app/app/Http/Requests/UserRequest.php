<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users,email,' . ($this->user ? $this->user->id : ''),
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            'phone' => 'required|string|max:20',
            'role_id' => 'required|integer|in:1,2,3,4,5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ];
    }
}
