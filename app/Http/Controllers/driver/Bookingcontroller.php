<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $driver = Auth::guard('agent')->user();

        if (!$driver->is_driver) {
            return redirect()->route('agen.dashboard');
        }

        $bookings = Booking::where('agent_id', $driver->id)
            ->latest()
            ->paginate(10);

        return view('driver.bookings.index', compact('driver', 'bookings'));
    }

    public function show($id)
    {
        $driver  = Auth::guard('agent')->user();
        $booking = Booking::where('agent_id', $driver->id)->findOrFail($id);

        return view('driver.bookings.show', compact('driver', 'booking'));
    }

    public function confirm($id)
    {
        $driver  = Auth::guard('agent')->user();
        $booking = Booking::where('agent_id', $driver->id)
            ->where('status', 'pending')
            ->findOrFail($id);

        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Pemesanan berhasil dikonfirmasi!');
    }

    public function complete($id)
    {
        $driver  = Auth::guard('agent')->user();
        $booking = Booking::where('agent_id', $driver->id)
            ->whereIn('status', ['confirmed', 'ongoing'])
            ->findOrFail($id);

        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Pemesanan ditandai selesai!');
    }

    public function cancel($id)
    {
        $driver  = Auth::guard('agent')->user();
        $booking = Booking::where('agent_id', $driver->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->findOrFail($id);

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Pemesanan dibatalkan.');
    }
}