<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Vehicle;
use App\Models\Apartment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\ReservationRequest;
use App\Notifications\ReservationCreatedNotification;

class ReservationController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $reservations = Reservation::all();
        return $this->successResponse($reservations, 'Rezervasyonlar başarıyla getirildi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
        try {
            $reservation = Reservation::create($request->validated());
    
        
            $user = User::find($request->user_id);
    
            
            $user->notify(new ReservationCreatedNotification($reservation));
    
            return $this->successResponse($reservation, 'Rezervasyon başarıyla oluşturuldu', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Rezervasyon oluşturulamadı', [$e->getMessage()]);
        }
    }

    public function show($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return $this->errorResponse('Rezervasyon bulunamadı', [], 404);
        }

        return $this->successResponse($reservation, 'Rezervasyon başarıyla getirildi');
    }

    public function update(ReservationRequest $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return $this->errorResponse('Rezervasyon bulunamadı', [], 404);
        }

        $validated = $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
        ]);

        try {
            $reservation->update($validated);
            return $this->successResponse($reservation, 'Rezervasyon başarıyla güncellendi');
        } catch (\Exception $e) {
            return $this->errorResponse('Rezervasyon güncellenemedi', [$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return $this->errorResponse('Rezervasyon bulunamadı', [], 404);
        }

        try {
            $reservation->delete();
            return $this->successResponse([], 'Rezervasyon başarıyla silindi');
        } catch (\Exception $e) {
            return $this->errorResponse('Rezervasyon silinemedi', [$e->getMessage()]);
        }
    }
    public function myReservations($id)
    {
        $user = User::with('role')->find($id);

        if (!$user) {
            return $this->errorResponse('Kullanıcı bulunamadı', [], 404);
        }

        $reservations = collect();  // Initialize empty collection

        switch ($user->role->name) {
            case 'hotel_owner':
                // Fetch reservations for the hotels owned by the user
                $reservations = Reservation::whereIn(
                    'reservation_item_id',
                    Hotel::where('user_id', $user->id)->pluck('id')
                )->where('reservation_type', 'room')->get();
                break;

            case 'apartment_owner':
                // Fetch reservations for the apartments owned by the user
                $reservations = Reservation::whereIn(
                    'reservation_item_id',
                    Apartment::where('user_id', $user->id)->pluck('id')
                )->where('reservation_type', 'apartment')->get();
                break;

            case 'car_owner':
                // Fetch reservations for the vehicles owned by the user
                $reservations = Reservation::whereIn(
                    'reservation_item_id',
                    Vehicle::where('user_id', $user->id)->pluck('id')
                )->where('reservation_type', 'vehicle')->get();
                break;

            case 'normal_user':
                // Fetch reservations that belong directly to the user
                $reservations = Reservation::where('user_id', $user->id)->get();
                break;

            default:
                return $this->errorResponse('Geçersiz kullanıcı rolü', [], 403);
        }

        return $this->successResponse($reservations, 'Rezervasyonlar başarıyla getirildi');
    }
}
