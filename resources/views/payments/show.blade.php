@extends('layouts.app')

@section('content')
<style>
    .payment-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }
    @media (max-width: 768px) {
        .payment-container {
            grid-template-columns: 1fr;
            margin: 20px auto;
        }
    }
    .panel-card {
        background: #1a1715;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(216, 182, 122, 0.15);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        height: fit-content;
    }
    .payment-title {
        color: #d8b67a;
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        margin-top: 0;
        margin-bottom: 24px;
        border-bottom: 1px solid rgba(216, 182, 122, 0.15);
        padding-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .detail-group {
        margin-bottom: 20px;
    }
    .detail-group:last-child {
        margin-bottom: 0;
    }
    .detail-label {
        color: #999;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: block;
        margin-bottom: 5px;
    }
    .detail-value {
        color: white;
        font-weight: bold;
        font-size: 16px;
    }
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 1px;
    }
    .status-completed {
        background: rgba(76, 175, 80, 0.15);
        color: #4caf50;
        border: 1px solid rgba(76, 175, 80, 0.3);
    }
    .status-pending {
        background: rgba(255, 152, 0, 0.15);
        color: #ff9800;
        border: 1px solid rgba(255, 152, 0, 0.3);
    }
    .status-cancelled {
        background: rgba(244, 67, 54, 0.15);
        color: #f44336;
        border: 1px solid rgba(244, 67, 54, 0.3);
    }
    .action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        max-width: 1000px;
        margin: 0 auto 40px auto;
        padding: 0 20px;
    }
    .action-btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }
    .btn-back {
        background: rgba(216, 182, 122, 0.1);
        color: #d8b67a;
        border: 1px solid rgba(216, 182, 122, 0.3);
    }
    .btn-back:hover {
        background: rgba(216, 182, 122, 0.2);
    }
    .btn-edit {
        background: #2196f3;
        color: white;
    }
    .btn-edit:hover {
        background: #0b7dda;
        box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
    }
    .btn-approve {
        background: #4caf50;
        color: white;
    }
    .btn-approve:hover {
        background: #45a049;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }
    .btn-cancel {
        background: #f44336;
        color: white;
    }
    .btn-cancel:hover {
        background: #da190b;
        box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
    }
    .alert-box {
        max-width: 1000px;
        margin: 20px auto 0 auto;
        padding: 0 20px;
    }
    .alert-content {
        padding: 16px 20px;
        border-radius: 12px;
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .alert-success {
        background: rgba(76, 175, 80, 0.15);
        border: 1px solid rgba(76, 175, 80, 0.4);
        color: #4caf50;
    }
    .alert-info {
        background: rgba(33, 150, 243, 0.15);
        border: 1px solid rgba(33, 150, 243, 0.4);
        color: #2196f3;
    }
</style>

{{-- ALERT NOTIFICATIONS --}}
<div class="alert-box">
    @if($message = Session::get('success'))
        <div class="alert-content alert-success">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ $message }}
        </div>
    @endif

    @if($message = Session::get('info'))
        <div class="alert-content alert-info">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ $message }}
        </div>
    @endif
</div>

{{-- DETAILS CONTAINER --}}
<div class="payment-container">
    {{-- LEFT CARD: PAYMENT DETAILS --}}
    <div class="panel-card">
        <h2 class="payment-title">
            <span>Detail Pembayaran</span>
            <span style="color: #999; font-size: 14px; font-family: 'Poppins', sans-serif; font-weight: normal;">#{{ $payment->id }}</span>
        </h2>
        
        <div class="detail-group">
            <span class="detail-label">Jumlah Pembayaran</span>
            <span class="detail-value" style="color: #d8b67a; font-size: 22px;">
                Rp {{ number_format($payment->amount, 0, ',', '.') }}
            </span>
        </div>

        <div class="detail-group">
            <span class="detail-label">Metode Pembayaran</span>
            <span class="detail-value">
                @if($payment->payment_method === 'qris')
                    QRIS
                @elseif($payment->payment_method === 'transfer')
                    Transfer Bank
                @elseif($payment->payment_method === 'card')
                    Kartu Kredit
                @else
                    {{ ucfirst($payment->payment_method) }}
                @endif
            </span>
        </div>

        @if($payment->payment_method === 'transfer' && $payment->bank_account)
            <div class="detail-group">
                <span class="detail-label">Rekening Pengirim</span>
                <span class="detail-value" style="background: rgba(216, 182, 122, 0.08); padding: 8px 12px; border-radius: 6px; border: 1px solid rgba(216, 182, 122, 0.15); display: inline-block;">
                    {{ $payment->bank_account }}
                </span>
            </div>
        @endif

        <div class="detail-group">
            <span class="detail-label">Status</span>
            <div>
                @if($payment->status === 'completed')
                    <span class="status-badge status-completed">✓ SELESAI</span>
                @elseif($payment->status === 'pending')
                    <span class="status-badge status-pending">⏳ MENUNGGU</span>
                @else
                    <span class="status-badge status-cancelled">✕ DIBATALKAN</span>
                @endif
            </div>
        </div>

        @if($payment->transaction_id)
            <div class="detail-group">
                <span class="detail-label">No. Transaksi / ID Referensi</span>
                <span class="detail-value" style="font-family: monospace; font-size: 14px; word-break: break-all;">
                    {{ $payment->transaction_id }}
                </span>
            </div>
        @endif

        <div class="detail-group">
            <span class="detail-label">Tanggal Pengajuan</span>
            <span class="detail-value" style="font-weight: normal; color: #ccc;">
                {{ $payment->created_at->format('d M Y, H:i') }} WIB
            </span>
        </div>

        @if($payment->proof_image)
            <div class="detail-group" style="margin-top: 25px;">
                <span class="detail-label" style="margin-bottom: 8px;">Bukti Pembayaran</span>
                <a href="{{ asset('storage/payments/' . $payment->proof_image) }}" target="_blank" title="Klik untuk memperbesar">
                    <img src="{{ asset('storage/payments/' . $payment->proof_image) }}" style="width: 100%; max-height: 350px; object-fit: contain; border-radius: 12px; border: 1px solid rgba(216, 182, 122, 0.25); transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.01)'" onmouseout="this.style.transform='scale(1)'">
                </a>
            </div>
        @endif
    </div>

    {{-- RIGHT CARD: APPOINTMENT DETAILS --}}
    <div class="panel-card">
        <h2 class="payment-title">Detail Janji Temu</h2>
        
        <div class="detail-group">
            <span class="detail-label">Layanan</span>
            <span class="detail-value" style="font-size: 18px; color: #d8b67a;">
                {{ $payment->appointment->service->name ?? '-' }}
            </span>
        </div>

        <div class="detail-group">
            <span class="detail-label">Stylist</span>
            <span class="detail-value">
                {{ $payment->appointment->stylist->name ?? '-' }}
            </span>
        </div>

        <div class="detail-group">
            <span class="detail-label">Tanggal Appointment</span>
            <span class="detail-value">
                {{ $payment->appointment->appointment_date }}
            </span>
        </div>

        <div class="detail-group">
            <span class="detail-label">Jam Pengerjaan</span>
            <span class="detail-value">
                {{ $payment->appointment->appointment_time }}
            </span>
        </div>

        <div class="detail-group">
            <span class="detail-label">Status Appointment</span>
            <span class="detail-value" style="color: #d8b67a; text-transform: uppercase; font-size: 14px;">
                {{ $payment->appointment->status }}
            </span>
        </div>

        @if($payment->notes)
            <div class="detail-group" style="margin-top: 25px; border-top: 1px solid rgba(216, 182, 122, 0.15); padding-top: 20px;">
                <span class="detail-label">Catatan Pembayaran</span>
                <p style="color: #ccc; margin: 0; line-height: 1.6; font-size: 14px;">
                    {{ $payment->notes }}
                </p>
            </div>
        @endif
    </div>
</div>

{{-- FOOTER / ACTIONS BAR --}}
<div class="action-bar">
    {{-- Back button: admin goes to Appointments list, customer goes to payments list --}}
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.appointments.index') }}" class="action-btn btn-back">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Appointments
        </a>
        <div style="display:inline-flex; align-items:center; gap:10px; padding:12px 20px; background:rgba(216,182,122,0.06); border:1px solid rgba(216,182,122,0.15); border-radius:10px; color:#8e857b; font-size:13px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Konfirmasi pembayaran dilakukan melalui menu Appointments
        </div>
    @else
        <a href="{{ route('payments.index') }}" class="action-btn btn-back">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>

        @if($payment->status !== 'completed')
            <a href="{{ route('payments.edit', $payment->id) }}" class="action-btn btn-edit">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Bukti
            </a>
        @endif
    @endif
</div>
@endsection

