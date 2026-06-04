<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class TravelDriver extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'vehicle_type',
        'vehicle_capacity',
        'price_per_day',
        'routes',
        'rating',
        'total_reviews',
        'is_available',
        'profile_photo',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'routes'       => 'array',
        'is_available' => 'boolean',
        'rating'       => 'float',
        'price_per_day'=> 'integer',
    ];

    // Hanya driver active yang muncul di publik
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Filter by rute (LIKE search di dalam JSON)
    public function scopeByRoute($query, string $route)
    {
        return $query->where('routes', 'like', "%{$route}%");
    }
}