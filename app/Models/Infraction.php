<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infraction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'longitude',
        'latitude',
        'height',
        'velocity',
        'image_id',
        'vehicle_id',
        'city_id',
    ];

    public function vehicle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
