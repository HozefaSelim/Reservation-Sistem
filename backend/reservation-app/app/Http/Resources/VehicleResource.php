<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Basic vehicle data
        $vehicleData = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'model' => $this->model,
            'brand' => $this->brand,
            'license_plate' => $this->license_plate,
            'available' => $this->available,
            'rating' => $this->rating,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'images' => $this->images->map(fn($image) => $image->url),
        ];

        // Load owner only when showing a single vehicle (show route)
        if ($request->routeIs('vehicles.show')) {
            $vehicleData['owner'] = [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ];

             // Reviews Information
             $vehicleData['reviews'] = $this->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'user' => $review->user->name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                ];
            });
        }

        
        return $vehicleData;
    }
}
