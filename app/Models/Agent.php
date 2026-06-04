<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    protected $table = 'agents';

    protected $fillable = [
        'nik', 'agency_name', 'email', 'password', 'phone', 'whatsapp',
        'city', 'province', 'address', 'description', 'ktp_photo', 'status',
        // Kolom driver
        'is_driver', 'vehicle_type', 'vehicle_capacity', 'price_per_day',
        'routes', 'rating', 'total_reviews', 'is_available',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'routes'       => 'array',
        'is_driver'    => 'boolean',
        'is_available' => 'boolean',
        'rating'       => 'float',
        'price_per_day'=> 'integer',
    ];

    // Hanya agent/driver yang active
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Hanya yang aktif sebagai driver travel
    public function scopeDrivers($query)
    {
        return $query->where('is_driver', true)->where('status', 'active');
    }

    // Filter by rute
    public function scopeByRoute($query, string $route)
    {
        return $query->where('routes', 'like', "%{$route}%");
    }
}