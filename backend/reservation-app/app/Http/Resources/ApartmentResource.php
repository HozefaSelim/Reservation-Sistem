<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Basic apartment data
        $apartmentData = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'price' => $this->price,
            'capacity' => $this->capacity,
            'rating' => $this->rating,
            'discounted_price' => $this->discounted_price,
            'available' => $this->available,
            'images' => $this->images->map(fn($image) => $image->url),
        ];

        // Load owner only when showing a single apartment (show route)
        if ($request->routeIs('apartments.show')) {
            $apartmentData['owner'] = [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ];
              // Reviews Information
         $apartmentData['reviews'] = $this->reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'user' => $review->user->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
            ];
        });
        }
       

        return $apartmentData;
    }
}
