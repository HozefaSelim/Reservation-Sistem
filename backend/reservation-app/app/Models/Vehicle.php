<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory, UuidTrait;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name' , 'model', 'brand', 'license_plate', 'available', 'rating', 'price', 'user_id'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($vehicle) {
            $vehicle->reviews()->delete();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
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
