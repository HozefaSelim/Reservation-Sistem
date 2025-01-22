<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\VehicleResource;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $vehicles = Vehicle::with('images')->get();
        return $this->successResponse(VehicleResource::collection($vehicles), 'Araçlar başarıyla getirildi');
    }

    public function store(VehicleRequest $request)
    {
        try {
            $user = User::find($request->user_id);
            if (!$user) {
                return $this->errorResponse('Yetkisiz erişim. Lütfen giriş yapın.', [], 401);
            }



            if ($user->role->name === 'normal_user') {
                $user->update(['role_id' => 4]);
            }


            $vehicle = Vehicle::create(array_merge(
                $request->validated(),
                ['user_id' => $user->id]
            ));

            if ($request->hasFile('images')) {
                $this->storeImages($request, $vehicle);
            }

            return $this->successResponse(new VehicleResource($vehicle), 'Araç başarıyla oluşturuldu', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Araç oluşturulamadı', [$e->getMessage()], 500);
        }
    }


    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['user', 'images']);
        return $this->successResponse(new VehicleResource($vehicle), 'Araç başarıyla getirildi');
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        try {
            $vehicle->update($request->validated());

            // Handle image update
            if ($request->hasFile('images')) {
                $this->deleteImages($vehicle);
                $this->storeImages($request, $vehicle);
            }

            return $this->successResponse(new VehicleResource($vehicle), 'Araç başarıyla güncellendi');
        } catch (\Exception $e) {
            return $this->errorResponse('Araç güncellenemedi', [$e->getMessage()], 500);
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            // Delete associated images
            $this->deleteImages($vehicle);

            $vehicle->delete();
            return $this->successResponse([], 'Araç başarıyla silindi', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Araç silinemedi', [$e->getMessage()], 500);
        }
    }

    /**
     * Store vehicle images and associate them with the vehicle.
     */
    private function storeImages(Request $request, Vehicle $vehicle)
    {
        foreach ($request->file('images') as $image) {
            // Store images in public/vehicle_images
            $path = $image->store('vehicle_images', 'public');

            // Save relative path in DB
            $vehicle->images()->create([
                'url' => $path,
            ]);
        }
    }

    /**
     * Delete vehicle images from storage and DB.
     */
    private function deleteImages(Vehicle $vehicle)
    {
        foreach ($vehicle->images as $image) {
            Storage::disk('public')->delete($image->url);
            $image->delete();
        }
    }

    public function getBrandsAndModels()
    {
        try {
            // Retrieve all brands and models
            $brands = Vehicle::distinct()->pluck('brand');
            $models = Vehicle::distinct()->pluck('model');

            // Handle the case where no records are found
            if ($brands->isEmpty() || $models->isEmpty()) {
                return $this->errorResponse('Araç markaları veya modelleri bulunamadı', [], 404);
            }

            return $this->successResponse([
                'brands' => $brands,
                'models' => $models,
            ], 'Araç markaları ve modelleri başarıyla getirildi');
        } catch (\Exception $e) {
            return $this->errorResponse('Markalar ve modeller getirilemedi', [$e->getMessage()], 500);
        }
    }

    public function searchVehicles(Request $request)
    {
        try {
            $query = Vehicle::query();

            if ($request->filled('brand')) {
                $query->where('brand', 'like', '%' . $request->brand . '%');
            }

            if ($request->filled('model')) {
                $query->where('model', 'like', '%' . $request->model . '%');
            }

            if ($request->filled('rating')) {
                $query->where('rating', '>=', $request->rating);
            }
            // Filter by minimum price
            if ($request->filled('price_min')) {
                $query->where('price', '>=', $request->price_min);
            }

            // Filter by maximum price
            if ($request->filled('price_max')) {
                $query->where('price', '<=', $request->price_max);
            }

            if ($request->filled('available')) {
                $query->where('available', $request->available);
            }
            $vehicles = $query->get();
            return $this->successResponse(VehicleResource::collection($vehicles), 'Vehicles filtered successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to filter vehicles', [$e->getMessage()], 500);
        }
    }

    public function changeAvailability(Vehicle $vehicle)
    {
        $vehicle->update(['available' => !$vehicle->available]);  // عكس القيمة الحالية
        $status = $vehicle->available ? 'etkinleştirildi' : 'devre dışı bırakıldı';

        return $this->successResponse(new VehicleResource($vehicle), "Araç başarıyla $status");
    }
}
