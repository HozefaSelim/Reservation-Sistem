<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{

    use HasFactory, UuidTrait;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'description', 'location', 'rating', 'user_id'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($hotel) {
            $hotel->reviews()->delete();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
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
