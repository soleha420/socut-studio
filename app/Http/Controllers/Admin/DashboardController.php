<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Stylist;

class DashboardController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user', 'service', 'stylist', 'latestPayment'])
            ->latest()
            ->get();

        $services = Service::all();
        $stylists = Stylist::all();

        return view('admin.dashboard', compact(
            'appointments',
            'services',
            'stylists'
        ));
    }
}