<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\ApartmentRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ApartmentResource;

class ApartmentController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $apartments = Apartment::all();
        return $this->successResponse(ApartmentResource::collection($apartments), 'Apartmanlar başarıyla getirildi');
    }

    public function store(ApartmentRequest $request)
    {
        try {
            $user = User::find($request->user_id);
            if (!$user) {
                return $this->errorResponse('Yetkisiz erişim. Lütfen giriş yapın.', [], 401);
            }
            if ($user->role->name === 'normal_user') {
                $user->update(['role_id' => 3]);
            }


            $apartment = Apartment::create(array_merge(
                $request->validated(),
                ['user_id' => $user->id]
            ));


            if ($request->hasFile('images')) {
                $this->storeImages($request, $apartment);
            }

            return $this->successResponse(new ApartmentResource($apartment), 'Apartman başarıyla oluşturuldu', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Apartman oluşturulamadı', [$e->getMessage()], 500);
        }
    }


    public function show(Apartment $apartment)
    {
        $apartment->load(['user', 'images']);
        return $this->successResponse(new ApartmentResource($apartment), 'Apartman başarıyla getirildi');
    }

    public function update(ApartmentRequest $request, Apartment $apartment)
    {
        try {
            $apartment->update($request->validated());

            // Handle image update
            if ($request->hasFile('images')) {
                $this->deleteImages($apartment);
                $this->storeImages($request, $apartment);
            }

            return $this->successResponse(new ApartmentResource($apartment), 'Apartman başarıyla güncellendi');
        } catch (\Exception $e) {
            return $this->errorResponse('Apartman güncellenemedi', [$e->getMessage()], 500);
        }
    }

    public function destroy(Apartment $apartment)
    {
        try {
            // Delete images before deleting apartment
            $this->deleteImages($apartment);

            // Delete the apartment
            $apartment->delete();

            return $this->successResponse([], 'Apartman başarıyla silindi', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Apartman silinemedi', [$e->getMessage()], 500);
        }
    }

    public function searchApartments(Request $request)
    {
        try {
            $query = Apartment::query();

            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->filled('rating')) {
                $query->where('rating', '>=', $request->rating);
            }

            if ($request->filled('location')) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            // Filter by minimum price
            if ($request->filled('price_min')) {
                $query->where('price', '>=', $request->price_min);
            }

            // Filter by maximum price
            if ($request->filled('price_max')) {
                $query->where('price', '<=', $request->price_max);
            }
            if ($request->filled('capacity')) {
                $query->where('capacity', '>=', $request->capacity);
            }

            if ($request->filled('available')) {
                $query->where('available', $request->available);
            }

            $apartments = $query->get();
            return $this->successResponse(ApartmentResource::collection($apartments), 'Apartments filtered successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to filter apartments', [$e->getMessage()], 500);
        }
    }

    /**
     * Handle storing images and saving paths to DB.
     */
    private function storeImages(Request $request, Apartment $apartment)
    {
        foreach ($request->file('images') as $image) {
            // Store image in public/apartment_images
            $path = $image->store('apartment_images', 'public');

            // Save relative path in DB (without asset URL)
            $apartment->images()->create([
                'url' => $path,  // Store relative path
            ]);
        }
    }

    /**
     * Handle deleting images from storage and DB.
     */
    private function deleteImages(Apartment $apartment)
    {
        foreach ($apartment->images as $image) {
            // Delete from storage
            Storage::disk('public')->delete($image->url);

            // Delete image record from DB
            $image->delete();
        }
    }


    public function changeAvailability(Apartment $apartment)
    {
        $apartment->update(['available' => !$apartment->available]);  // عكس القيمة الحالية
        $status = $apartment->available ? 'etkinleştirildi' : 'devre dışı bırakıldı';

        return $this->successResponse(new ApartmentResource($apartment), "Apartman başarıyla $status");
    }
}
