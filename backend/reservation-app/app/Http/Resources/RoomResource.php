<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Basic hotel data
        $roomData = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'capacity' => $this->capacity,
            'count' => $this->count,
            'rating' => $this->rating,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'available' => $this->available,
            'images' => $this->images->map(fn($image) => $image->url),
        ];

        if ($request->routeIs('rooms.show')) {
            $roomData['hotel'] = [
                'id' => $this->hotel->id,
                'name' => $this->hotel->name,
                'description' => $this->hotel->description,
                'location' => $this->hotel->location,
                'rating' => $this->hotel->rating,
            ];
             // Reviews Information
             $roomData['reviews'] = $this->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'user' => $review->user->name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                ];
            });

        }

        return $roomData;
    }
}
