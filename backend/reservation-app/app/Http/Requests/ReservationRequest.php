<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'reservation_type' => 'required|in:room,apartment,vehicle',
            'reservation_item_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $reservationType = $this->reservation_type;
            $itemId = $this->reservation_item_id;

            switch ($reservationType) {
                case 'room':
                    if (!\App\Models\Room::where('id', $itemId)->exists()) {
                        $validator->errors()->add('reservation_item_id', 'Seçilen oda mevcut değil.');
                    }
                    break;
                case 'apartment':
                    if (!\App\Models\Apartment::where('id', $itemId)->exists()) {
                        $validator->errors()->add('reservation_item_id', 'Seçilen daire mevcut değil.');
                    }
                    break;
                case 'vehicle':
                    if (!\App\Models\Vehicle::where('id', $itemId)->exists()) {
                        $validator->errors()->add('reservation_item_id', 'Seçilen araç mevcut değil.');
                    }
                    break;
                default:
                    $validator->errors()->add('reservation_type', 'Geçersiz rezervasyon tipi.');
            }
        });
    }
}
