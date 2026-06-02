<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['appointment', 'user'])->orderBy('created_at', 'desc')->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['appointment', 'user'])->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    public function create($appointment_id)
    {
        $appointment = Appointment::with(['service', 'stylist'])->findOrFail($appointment_id);
        
        // Check if payment already exists
        $existingPayment = Payment::where('appointment_id', $appointment_id)->first();
        if ($existingPayment) {
            return redirect()->route('payments.show', $existingPayment->id)
                ->with('info', 'Pembayaran untuk appointment ini sudah dibuat.');
        }

        return view('payments.create', compact('appointment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:transfer,qris,card',
            'bank_account' => 'nullable|string|max:255',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($validated['appointment_id']);

        $paymentData = [
            'appointment_id' => $validated['appointment_id'],
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'bank_account' => $validated['bank_account'] ?? null,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ];

        // Handle proof image upload
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $filename = 'payment_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('payments', $filename, 'public');
            $paymentData['proof_image'] = $filename;
        }

        $payment = Payment::create($paymentData);

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Pembayaran berhasil dibuat! Tunggu konfirmasi admin.');
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        
        // Prevent admin from editing payment
        if (auth()->user()->role === 'admin') {
            return redirect()->route('payments.show', $id)
                ->with('error', 'Admin tidak diperbolehkan mengubah pembayaran.');
        }
        
        // Only allow editing if not completed
        if ($payment->status === 'completed') {
            return redirect()->route('payments.show', $id)
                ->with('error', 'Tidak dapat mengubah pembayaran yang sudah selesai.');
        }

        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        // Prevent admin from updating payment
        if (auth()->user()->role === 'admin') {
            return redirect()->route('payments.show', $id)
                ->with('error', 'Admin tidak diperbolehkan mengubah pembayaran.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:transfer,qris,card',
            'bank_account' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
        ]);

        $updateData = [
            'payment_method' => $validated['payment_method'],
            'bank_account' => $validated['bank_account'] ?? null,
            'amount' => $validated['amount'],
            'notes' => $validated['notes'],
        ];

        // Handle proof image upload
        if ($request->hasFile('proof_image')) {
            // Delete old image
            if ($payment->proof_image) {
                \Storage::disk('public')->delete('payments/' . $payment->proof_image);
            }
            
            $file = $request->file('proof_image');
            $filename = 'payment_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('payments', $filename, 'public');
            $updateData['proof_image'] = $filename;
        }

        $payment->update($updateData);

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $payment->update($validated);

        // Update appointment status jika payment completed
        if ($validated['status'] === 'completed') {
            $payment->appointment->update(['status' => 'confirmed']);
        }

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        
        if ($payment->status === 'completed') {
            return redirect()->route('payments.index')
                ->with('error', 'Tidak dapat menghapus pembayaran yang sudah selesai.');
        }

        $appointmentId = $payment->appointment_id;
        $payment->delete();

        return redirect()->route('appointments.show', $appointmentId)
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
}
