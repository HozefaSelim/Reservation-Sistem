<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory, UuidTrait;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['url'];

    public function imagable()
    {
        return $this->morphTo();
    }
}
