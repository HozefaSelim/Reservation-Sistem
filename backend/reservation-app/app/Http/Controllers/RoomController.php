<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('images')->get();
        return $this->successResponse(RoomResource::collection($rooms), 'Odalar başarıyla getirildi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        try {

            $user = User::find($request->user_id);
            if (!$user) {
                return $this->errorResponse('Yetkisiz erişim. Lütfen giriş yapın.', [], 401);
            }


            $hotel = $user->hotel;

            if (!$hotel) {
                return $this->errorResponse('Bu kullanıcının oteli bulunmamaktadır.', [], 403);
            }


            $roomData = array_merge($request->validated(), ['hotel_id' => $hotel->id]);

            $room = Room::create($roomData);

            if ($request->hasFile('images')) {
                $this->storeImages($request, $room);
            }

            return $this->successResponse(new RoomResource($room), 'Oda başarıyla oluşturuldu', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Oda oluşturulamadı', [$e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $roomData = $room->load('hotel', 'images');
        return $this->successResponse(new RoomResource($roomData), 'Oda başarıyla getirildi');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, Room $room)
    {
        try {
            $room->update($request->validated());

            // Handle image update
            if ($request->hasFile('images')) {
                $this->deleteImages($room);
                $this->storeImages($request, $room);
            }

            return $this->successResponse($room, 'Oda başarıyla güncellendi');
        } catch (\Exception $e) {
            return $this->errorResponse('Oda güncellenemedi', [$e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            // Delete images
            $this->deleteImages($room);

            // Delete the room
            $room->delete();

            return $this->successResponse([], 'Oda başarıyla silindi', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Oda silinemedi', [$e->getMessage()], 500);
        }
    }

    /**
     * Search rooms by criteria.
     */
    public function searchRooms(Request $request)
    {
        $query = Room::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('capacity')) {
            $query->where('capacity', '>=', $request->capacity);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        if ($request->filled('available')) {
            $query->where('available', $request->available);
        }
        try {
            $rooms = $query->with('images')->get();
            return $this->successResponse(RoomResource::collection($rooms), 'Odalar başarıyla getirildi');
        } catch (\Exception $e) {
            return $this->errorResponse('Odaları arama başarısız oldu', [$e->getMessage()], 500);
        }
    }

    /**
     * Store room images.
     */
    private function storeImages(Request $request, Room $room)
    {
        foreach ($request->file('images') as $image) {
            // Store images in public/room_images
            $path = $image->store('room_images', 'public');

            // Save relative path in DB
            $room->images()->create([
                'url' => $path,
            ]);
        }
    }

    /**
     * Delete room images from storage and DB.
     */
    private function deleteImages(Room $room)
    {
        foreach ($room->images as $image) {
            Storage::disk('public')->delete($image->url);
            $image->delete();
        }
    }

    public function changeAvailability(Room $room)
    {
        $room->update(['available' => !$room->available]);  // عكس القيمة الحالية
        $status = $room->available ? 'etkinleştirildi' : 'devre dışı bırakıldı';

        return $this->successResponse(new RoomResource($room), "Oda başarıyla $status");
    }

    public function getRoomsByOwner($userId)
    {
        // Kullanıcının sahip olduğu otelleri ve odalarını getir
        $hotels = Hotel::where('user_id', $userId)->with('rooms.images')->get();

        // Otellerden tüm odaları çıkar
        $rooms = $hotels->flatMap->rooms;

        // Eğer oda bulunamazsa, 404 yanıtı döndür
        if ($rooms->isEmpty()) {
            return $this->errorResponse('Bu kullanıcı için oda bulunamadı.', [], 404);
        }

        // Yanıt yapısını hazırla
        $data = $rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'capacity' => $room->capacity,
                'price' => $room->price,
                'available' => $room->available,
                'hotel' => [
                    'id' => $room->hotel->id,
                    'name' => $room->hotel->name,
                    'location' => $room->hotel->location,
                ],
                'images' => $room->images->map(function ($image) {
                    return [
                        'url' => asset('storage/' . $image->url),
                    ];
                }),
            ];
        });

        return $this->successResponse($data, 'Odalar başarıyla getirildi.');
    }
}
