<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, UuidTrait;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [ 'reservation_id', 'payment_method', 'amount', 'status'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
