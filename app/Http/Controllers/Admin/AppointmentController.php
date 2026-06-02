<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user', 'service', 'stylist', 'latestPayment'])
            ->latest()
            ->get();

        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $services = Service::all();
        $stylists = Stylist::all();

        return view('admin.appointments.create', compact('users', 'services', 'stylists'));
    }

    public function store(Request $request)
    {
        Appointment::create([
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'stylist_id' => $request->stylist_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function edit(Appointment $appointment)
    {
        $users = User::where('role', 'user')->get();
        $services = Service::all();
        $stylists = Stylist::all();

        return view('admin.appointments.edit', compact('appointment', 'users', 'services', 'stylists'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $appointment->update([
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'stylist_id' => $request->stylist_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $newStatus = $request->status;

        // Update appointment status
        $appointment->update(['status' => $newStatus]);

        // Simultaneously update the related payment status in one action
        $payment = $appointment->latestPayment()->first();
        if ($payment) {
            if ($newStatus === 'approved') {
                // Approve appointment => payment is confirmed/completed
                $payment->update(['status' => 'completed']);
            } elseif ($newStatus === 'rejected') {
                // Reject appointment => payment is cancelled
                $payment->update(['status' => 'cancelled']);
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Appointment dan pembayaran berhasil diperbarui sekaligus.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index');
    }
}