<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $driver = Auth::guard('agent')->user();

        // Pastikan yang akses adalah driver
        if (!$driver->is_driver) {
            return redirect()->route('agen.dashboard');
        }

        $stats = [
            'total_bookings'   => Booking::where('agent_id', $driver->id)->count(),
            'pending_bookings' => Booking::where('agent_id', $driver->id)->where('status', 'pending')->count(),
            'active_bookings'  => Booking::where('agent_id', $driver->id)->whereIn('status', ['confirmed', 'ongoing'])->count(),
            'done_bookings'    => Booking::where('agent_id', $driver->id)->where('status', 'completed')->count(),
            'total_income'     => Booking::where('agent_id', $driver->id)->where('status', 'completed')->sum('total_price'),
            'rating'           => $driver->rating ?? 0,
        ];

        $recentBookings = Booking::where('agent_id', $driver->id)
            ->latest()
            ->take(5)
            ->get();

        return view('driver.dashboard', compact('driver', 'stats', 'recentBookings'));
    }
}