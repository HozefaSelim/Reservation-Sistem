<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory, UuidTrait;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'description', 'count', 'capacity', 'price', 'discounted_price', 'available', 'hotel_id'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($room) {
            $room->reviews()->delete();
        });
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
