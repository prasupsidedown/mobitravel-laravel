<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;

class AgentVerificationController extends Controller
{
    // ==============================
    // AGEN
    // ==============================

    // Daftar semua agen (is_driver = false)
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $agents = Agent::where('is_driver', false)
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.agents.index', compact('agents', 'status'));
    }

    // Detail agen
    public function show($id)
    {
        $agent = Agent::findOrFail($id);
        return view('admin.agents.show', compact('agent'));
    }

    // Verifikasi / setujui agen
    public function verify($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = 'active';
        $agent->verified_at = now();
        $agent->save();

        $route = $agent->is_driver ? 'admin.drivers.index' : 'admin.agents.index';

        return redirect()->route($route, ['status' => 'pending'])
            ->with('success', "Akun {$agent->agency_name} telah diverifikasi.");
    }

    // Tolak
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10'
        ]);

        $agent = Agent::findOrFail($id);
        $agent->status = 'suspended';
        $agent->save();

        $route = $agent->is_driver ? 'admin.drivers.index' : 'admin.agents.index';

        return redirect()->route($route, ['status' => 'pending'])
            ->with('success', "Akun {$agent->agency_name} telah ditolak.");
    }

    // Hapus
    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $name = $agent->agency_name;
        $isDriver = $agent->is_driver;
        $agent->delete();

        $route = $isDriver ? 'admin.drivers.index' : 'admin.agents.index';

        return redirect()->route($route)
            ->with('success', "Akun {$name} telah dihapus.");
    }

    // Suspend
    public function suspend($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = 'suspended';
        $agent->save();

        return redirect()->back()->with('success', "Akun {$agent->agency_name} telah ditangguhkan.");
    }

    // Aktifkan kembali
    public function activate($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = 'active';
        $agent->save();

        return redirect()->back()->with('success', "Akun {$agent->agency_name} telah diaktifkan kembali.");
    }

    // ==============================
    // DRIVER
    // ==============================

    // Daftar semua driver (is_driver = true)
    public function indexDrivers(Request $request)
    {
        $status = $request->get('status', 'pending');

        $drivers = Agent::where('is_driver', true)
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.drivers.index', compact('drivers', 'status'));
    }

    // Detail driver
    public function showDriver($id)
    {
        $driver = Agent::where('is_driver', true)->findOrFail($id);
        return view('admin.drivers.show', compact('driver'));
    }
}