@extends('layouts.app')

@section('content')
<div style="max-width:1200px; margin:50px auto; padding:0 20px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:40px;">
        <h1 style="color:#d8b67a; font-size:32px; margin:0;">Daftar Pembayaran</h1>
        <a href="{{ route('dashboard') }}" style="background:#d8b67a; color:#1f1a17; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:bold;">
            Kembali
        </a>
    </div>

    @if($payments->count() > 0)
        <div style="background:#1a1715; border-radius:12px; overflow:hidden; border:1px solid rgba(216,182,122,0.2);">
            <table style="width:100%; color:white; border-collapse:collapse;">
                <thead>
                    <tr style="background:#2a2420; border-bottom:1px solid rgba(216,182,122,0.2);">
                        <th style="padding:16px; text-align:left; color:#d8b67a;">ID</th>
                        <th style="padding:16px; text-align:left; color:#d8b67a;">Appointment</th>
                        <th style="padding:16px; text-align:left; color:#d8b67a;">Jumlah</th>
                        <th style="padding:16px; text-align:left; color:#d8b67a;">Metode</th>
                        <th style="padding:16px; text-align:left; color:#d8b67a;">Status</th>
                        <th style="padding:16px; text-align:left; color:#d8b67a;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr style="border-bottom:1px solid rgba(216,182,122,0.1);">
                            <td style="padding:16px;">{{ $payment->id }}</td>
                            <td style="padding:16px;">
                                {{ $payment->appointment->service->name ?? 'N/A' }}
                                <br><small style="color:#999;">{{ $payment->appointment->appointment_date }}</small>
                            </td>
                            <td style="padding:16px; color:#d8b67a; font-weight:bold;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td style="padding:16px; text-transform:capitalize;">{{ $payment->payment_method }}</td>
                            <td style="padding:16px;">
                                @if($payment->status === 'completed')
                                    <span style="background:#4caf50; color:white; padding:4px 12px; border-radius:4px; font-size:12px;">✓ Selesai</span>
                                @elseif($payment->status === 'pending')
                                    <span style="background:#ff9800; color:white; padding:4px 12px; border-radius:4px; font-size:12px;">⏳ Menunggu</span>
                                @else
                                    <span style="background:#f44336; color:white; padding:4px 12px; border-radius:4px; font-size:12px;">✕ Dibatalkan</span>
                                @endif
                            </td>
                            <td style="padding:16px;">
                                <a href="{{ route('payments.show', $payment->id) }}" style="color:#d8b67a; text-decoration:none; font-weight:bold;">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $payments->links() }}
        </div>
    @else
        <div style="background:#1a1715; border-radius:12px; padding:40px; text-align:center; color:#999; border:1px solid rgba(216,182,122,0.2);">
            <p style="font-size:16px;">Belum ada pembayaran.</p>
        </div>
    @endif
</div>
@endsection
