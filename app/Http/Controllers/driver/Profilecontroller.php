<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $driver = Auth::guard('agent')->user();

        if (!$driver->is_driver) {
            return redirect()->route('agen.dashboard');
        }

        return view('driver.profile.index', compact('driver'));
    }

    public function update(Request $request)
    {
        $driver = Auth::guard('agent')->user();

        $request->validate([
            'agency_name' => 'required|string|max:255',
            'phone'       => 'required|string|max:15',
            'whatsapp'    => 'required|string|max:15',
            'city'        => 'required|string|max:100',
            'province'    => 'required|string|max:100',
            'address'     => 'required|string',
            'description' => 'nullable|string',
        ]);

        $driver->update($request->only([
            'agency_name', 'phone', 'whatsapp',
            'city', 'province', 'address', 'description',
        ]));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword(Request $request)
    {
        $driver = Auth::guard('agent')->user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $driver->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        $driver->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}