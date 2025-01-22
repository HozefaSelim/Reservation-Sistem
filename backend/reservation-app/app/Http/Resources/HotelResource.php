<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Basic hotel data
        $hotelData = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'rating' => $this->rating,
            'images' => $this->images->map(fn($image) => $image->url),
            'rooms' => RoomResource::collection($this->rooms),
        ];

        // Load owner and rooms only when showing a single hotel (show route)
        if ($request->routeIs('hotels.show')) {
            // Owner Information
            $hotelData['owner'] = [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ];

            // Rooms Information
            $hotelData['rooms'] = $this->rooms->map(function ($room) {
                return [
                    'id' => $room->id,
                    'name' => $room->name,
                    'capacity' => $room->capacity,
                    'description' => $room->description,
                    'price' => $room->price,
                    'discounted_price' => $room->discounted_price,
                    'rating' => $room->rating,
                    'available' => $room->available,
                ];
            });
            // Reviews Information
            $hotelData['reviews'] = $this->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'user' => $review->user->name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at,
                ];
            });
        }

        return $hotelData;
    }
}
