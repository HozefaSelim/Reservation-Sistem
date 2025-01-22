<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\HotelRequest;
use App\Http\Resources\HotelResource;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::all();
        return $this->successResponse(HotelResource::collection($hotels), 'Oteller başarıyla getirildi');
    }
    public function store(HotelRequest $request)
    {
        try {
        
            $user = User::find($request->user_id);
            if (!$user) {
                return $this->errorResponse('Yetkisiz erişim. Lütfen giriş yapın.', [], 401);
            }
      
            if ($user->role->name === 'normal_user') {
                $user->update(['role_id' => 2]);  
            }
            $hotel = Hotel::create(array_merge(
                $request->validated(),
                ['user_id' => $user->id]
            ));

            if ($request->hasFile('images')) {
                $this->storeImages($request, $hotel);
            }

            return $this->successResponse(new HotelResource($hotel), 'Otel başarıyla oluşturuldu', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Otel oluşturulamadı', [$e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        $hotel->load(['user', 'rooms', 'images']);
        return $this->successResponse(new HotelResource($hotel), 'Otel başarıyla getirildi');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HotelRequest $request, Hotel $hotel)
    {
        try {
            $hotel->update($request->validated());

            // Handle image update
            if ($request->hasFile('images')) {
                $this->deleteImages($hotel);
                $this->storeImages($request, $hotel);
            }

            return $this->successResponse(new HotelResource($hotel), 'Otel başarıyla güncellendi');
        } catch (\Exception $e) {
            return $this->errorResponse('Otel güncellenemedi', [$e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        try {
            // Delete associated images
            $this->deleteImages($hotel);

            // Delete the hotel
            $hotel->delete();

            return $this->successResponse([], 'Otel başarıyla silindi', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Otel silinemedi', [$e->getMessage()], 500);
        }
    }

    /**
     * Search hotels by various filters.
     */
    public function searchHotels(Request $request)
    {
        $query = Hotel::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        try {
            $hotels = $query->get();
            return $this->successResponse(HotelResource::collection($hotels), 'Otel başarıyla getirildi');
        } catch (\Exception $e) {
            return $this->errorResponse('Otel araması başarısız oldu', [$e->getMessage()], 500);
        }
    }

    /**
     * Store hotel images and associate them with the hotel.
     */
    private function storeImages(Request $request, Hotel $hotel)
    {
        foreach ($request->file('images') as $image) {
            // Store image in public/hotel_images
            $path = $image->store('hotel_images', 'public');

            // Save the path directly without the asset URL
            $hotel->images()->create([
                'url' => $path,  // Store relative path
            ]);
        }
    }

    /**
     * Delete hotel images from storage and DB.
     */
    private function deleteImages(Hotel $hotel)
    {
        foreach ($hotel->images as $image) {
            // Delete file from storage
            Storage::disk('public')->delete($image->url);

            // Delete image record from DB
            $image->delete();
        }
    }
}
