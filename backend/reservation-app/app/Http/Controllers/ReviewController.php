<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    public function addReview(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'reviewable_type' => 'required|string|in:hotel,vehicle,apartment,room',
            'reviewable_id' => 'required|uuid',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $model = $this->getModelClass($request->reviewable_type);

        $item = $model::findOrFail($request->reviewable_id);

        $review = $item->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'تمت إضافة المراجعة بنجاح', 'review' => $review], 201);
    }

    private function getModelClass($type)
    {
        return match ($type) {
            'hotel' => \App\Models\Hotel::class,
            'vehicle' => \App\Models\Vehicle::class,
            'apartment' => \App\Models\Apartment::class,
            'room' => \App\Models\Room::class,
            default => abort(404, 'invalid model'),
        };
    }
}
