<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TravelDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TravelDriverController extends Controller
{
    // GET /api/travel-drivers
    // Publik — list semua driver active, opsional filter by ?route=
    public function index(Request $request)
    {
        $query = TravelDriver::active();

        if ($request->filled('route')) {
            $query->byRoute($request->route);
        }

        $drivers = $query->orderByDesc('rating')->get();

        return response()->json([
            'success' => true,
            'data'    => $drivers,
        ]);
    }

    // GET /api/travel-drivers/{id}
    // Publik — detail 1 driver
    public function show($id)
    {
        $driver = TravelDriver::active()->find($id);

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $driver,
        ]);
    }

    // POST /api/travel-drivers/register
    // Publik — driver daftar sendiri, status default 'pending'
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'email'            => 'required|email|unique:travel_drivers,email',
            'password'         => 'required|string|min:8',
            'vehicle_type'     => 'required|string|max:100',
            'vehicle_capacity' => 'required|integer|min:1|max:100',
            'price_per_day'    => 'required|integer|min:0',
            'routes'           => 'required|array|min:1',
            'routes.*'         => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $driver = TravelDriver::create([
            'name'             => $request->name,
            'phone'            => $request->phone,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'vehicle_type'     => $request->vehicle_type,
            'vehicle_capacity' => $request->vehicle_capacity,
            'price_per_day'    => $request->price_per_day,
            'routes'           => $request->routes,
            'status'           => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil! Akun kamu sedang menunggu verifikasi admin.',
            'data'    => $driver,
        ], 201);
    }

    // PATCH /api/travel-drivers/{id}/availability
    // Protected — driver update status ketersediaannya sendiri
    public function updateAvailability(Request $request, $id)
    {
        $driver = TravelDriver::find($id);

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'is_available' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $driver->update(['is_available' => $request->is_available]);

        return response()->json([
            'success' => true,
            'message' => 'Status ketersediaan diperbarui',
            'data'    => $driver,
        ]);
    }
}