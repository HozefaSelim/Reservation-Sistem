<?php

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


// Route::middleware(['auth:sanctum'])->group(function () {

// });

Route::apiResource('hotels', HotelController::class);
Route::apiResource('rooms', RoomController::class);
Route::apiResource('apartments', ApartmentController::class);
Route::apiResource('vehicles', VehicleController::class);
Route::apiResource('users', UserController::class);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified']);


Route::get('/rooms_search', [RoomController::class, 'searchRooms']);
Route::get('/hotels_search', [HotelController::class, 'searchHotels']);
Route::get('/apartments_search', [ApartmentController::class, 'searchApartments']);
Route::get('/vehicles_search', [VehicleController::class, 'searchVehicles']);


Route::get('/vehicles-brands-models', [VehicleController::class, 'getBrandsAndModels']);
Route::get('/getRoomsOfHotel/{id}', [RoomController::class, 'getRoomsByOwner']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


// Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
// Route::post('/reset-password', [AuthController::class, 'resetPassword']);






Route::post('/email/verify/{id}', [AuthController::class, 'verify']);
Route::get('/email/verify/{id}', [AuthController::class, 'redirect'])->name('verification.verify');





Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification email resent.']);
})->middleware('auth:sanctum')->name('verification.resend');



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reviews', [ReviewController::class, 'addReview']);
    Route::apiResource('reservations', ReservationController::class);
    Route::get('/my-reservations/{id}', [ReservationController::class, 'myReservations']);
});

Route::patch('/rooms/{room}/change-availability', [RoomController::class, 'changeAvailability']);
Route::patch('/vehicles/{vehicle}/change-availability', [VehicleController::class, 'changeAvailability']);
Route::patch('/apartments/{apartment}/change-availability', [ApartmentController::class, 'changeAvailability']);
