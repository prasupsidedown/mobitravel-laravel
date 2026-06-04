<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function index()
    {
        $driver = Auth::guard('agent')->user();

        if (!$driver->is_driver) {
            return redirect()->route('agen.dashboard');
        }

        return view('driver.routes.index', compact('driver'));
    }

    public function update(Request $request)
    {
        $driver = Auth::guard('agent')->user();

        $request->validate([
            'routes_text'      => 'required|string',
            'vehicle_type'     => 'required|string',
            'vehicle_capacity' => 'required|integer|min:1|max:60',
            'price_per_day'    => 'required|integer|min:0',
        ]);

        $routes = array_map('trim', explode(',', $request->routes_text));

        $driver->update([
            'routes'           => $routes,
            'vehicle_type'     => $request->vehicle_type,
            'vehicle_capacity' => $request->vehicle_capacity,
            'price_per_day'    => $request->price_per_day,
        ]);

        return back()->with('success', 'Rute & info kendaraan berhasil diperbarui!');
    }

    public function updateAvailability(Request $request)
    {
        $driver = Auth::guard('agent')->user();

        $driver->update([
            'is_available' => $request->boolean('is_available'),
        ]);

        $status = $driver->is_available ? 'Tersedia' : 'Tidak Tersedia';

        return back()->with('success', "Status ketersediaan diubah menjadi: {$status}");
    }
}