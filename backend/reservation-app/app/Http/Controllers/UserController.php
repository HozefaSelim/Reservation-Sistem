<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('image')->get();
        return $this->successResponse(UserResource::collection($users), 'Kullanıcılar başarıyla getirildi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest  $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            // Handle image upload
            if ($request->hasFile('image')) {
                $this->storeImage($request, $user);
            }

            return $this->successResponse($user, 'Kullanıcı başarıyla oluşturuldu', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Kullanıcı oluşturulamadı', [$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['role', 'image']);

        switch ($user->role->name) {
            case 'hotel_owner':
                $userData = $user->load('hotels');
                break;
            case 'apartment_owner':
                $userData = $user->load('apartments');
                break;
            case 'vehicle_owner':
                $userData = $user->load('vehicles');
                break;
            default:
                $userData = $user;
                break;
        }

        return $this->successResponse(new UserResource($userData), 'Kullanıcı başarıyla alındı');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $data = $request->validated();

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $user->update($data);

            // Handle image update
            if ($request->hasFile('image')) {
                $this->deleteImage($user);
                $this->storeImage($request, $user);
            }

            return $this->successResponse(new UserResource($user), 'Kullanıcı başarıyla güncellendi');
        } catch (\Exception $e) {
            return $this->errorResponse('Kullanıcı güncellenemedi', [$e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Delete associated image before deleting the user
            $this->deleteImage($user);

            $user->delete();
            return $this->successResponse([], 'Kullanıcı başarıyla silindi', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Kullanıcı silinemedi', [$e->getMessage()], 500);
        }
    }

    /**
     * Store user image and associate it with the user.
     */
    private function storeImage(Request $request, User $user)
    {
        $path = $request->file('image')->store('user_images', 'public');

        $user->image()->create([
            'url' => $path,  // Save relative path
        ]);
    }

    /**
     * Delete user image from storage and DB.
     */
    private function deleteImage(User $user)
    {
        if ($user->image) {
            Storage::disk('public')->delete($user->image->url);
            $user->image()->delete();
        }
    }
}
