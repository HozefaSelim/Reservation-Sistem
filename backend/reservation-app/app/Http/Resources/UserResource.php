<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected ?string $token;

    // Pass the token through the constructor
    public function __construct($resource, $token = null)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    public function toArray(Request $request): array
    {
        // البيانات الأساسية للمستخدم
        $userData = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role->name,
            'image' => $this->whenLoaded('image', fn() => $this->image->url),
        ];

        // إرفاق التوكن إذا وُجد
        if ($this->token) {
            $userData['token'] = $this->token;
        }

        // إذا كان طلب المستخدم الفردي، يتم إضافة العلاقات
        if ($request->routeIs('users.show')) {
            switch ($this->role->name) {
                case 'hotel_owner':
                    $userData['hotels'] = $this->hotels->map(fn($hotel) => [
                        'id' => $hotel->id,
                        'name' => $hotel->name,
                        'location' => $hotel->location,
                        'rating' => $hotel->rating,
                    ]);
                    break;

                case 'apartment_owner':
                    $userData['apartments'] = $this->apartments->map(fn($apartment) => [
                        'id' => $apartment->id,
                        'name' => $apartment->name,
                        'location' => $apartment->location,
                        'price' => $apartment->price,
                    ]);
                    break;

                case 'vehicle_owner':
                    $userData['vehicles'] = $this->vehicles->map(fn($vehicle) => [
                        'id' => $vehicle->id,
                        'model' => $vehicle->model,
                        'license_plate' => $vehicle->license_plate,
                    ]);
                    break;
            }
        }

        return $userData;
    }
}
