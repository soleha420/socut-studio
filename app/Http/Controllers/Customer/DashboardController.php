<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Stylist;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['service', 'stylist'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // TAMBAHKAN SERVICES
        $services = Service::latest()->get();

        return view('customer.dashboard', compact(
            'appointments',
            'services'
        ));
    }

    

    public function services()
    {
        $services = Service::all();

        return view('customer.services', compact('services'));
    }
    public function booking(Request $request)
    {
        $services = Service::all();
        $stylists = Stylist::all();

        $selectedService = $request->service_id;

        return view('customer.booking', compact(
            'services',
            'stylists',
            'selectedService'
    ));
}
    public function stylists()
    {
        $stylists = Stylist::all();

        return view('customer.stylists', compact('stylists'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'stylist_id' => 'required',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);

        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'service_id' => $request->service_id,
            'stylist_id' => $request->stylist_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Redirect ke halaman pembayaran
        return redirect()
            ->route('payments.create', ['appointment_id' => $appointment->id])
            ->with('info', 'Silahkan selesaikan pembayaran untuk menyelesaikan booking.');
    }

    public function cancelBooking($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $appointment->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}