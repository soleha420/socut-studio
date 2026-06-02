@extends('layouts.admin')

@section('content')

<style>
    .hero-glass-card {
        background: rgba(20, 17, 15, 0.65);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(216, 182, 122, 0.15);
        border-radius: 24px;
        padding: 40px;
        max-width: 100%;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
    }
    .section-title {
        font-family: 'Poppins', sans-serif;
        font-size: 36px;
        color: #d8b67a;
        margin-bottom: 24px;
        position: relative;
        display: inline-block;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 60px;
        height: 2px;
        background: #d8b67a;
    }
    .history-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 20px;
    }
    .history-card {
        background: #14110f;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid rgba(216, 182, 122, 0.12);
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        display: grid;
        grid-template-columns: 2.2fr 1fr;
        align-items: center;
        gap: 20px;
    }
    .history-card.card-pending {
        border-left: 4px solid #ff9800 !important;
        background: rgba(255, 152, 0, 0.02) !important;
        box-shadow: 0 10px 35px rgba(255, 152, 0, 0.05);
    }
    @media (max-width: 768px) {
        .history-card {
            grid-template-columns: 1fr;
        }
    }
    .history-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px 24px;
    }
    @media (max-width: 480px) {
        .history-info {
            grid-template-columns: 1fr;
        }
    }
    .history-title {
        grid-column: 1 / -1;
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        color: #d8b67a;
        margin: 0 0 4px 0;
    }
    .meta-item {
        font-size: 14px;
        color: #c4bbb0;
    }
    .meta-item strong {
        color: #f8f7f6;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: bold;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    .pill-pending {
        background: rgba(255, 152, 0, 0.12);
        color: #ff9800;
        border: 1px solid rgba(255, 152, 0, 0.25);
    }
    .pill-pending .status-dot {
        background: #ff9800;
        animation: pulse 1.8s infinite;
    }
    .pill-confirmed {
        background: rgba(76, 175, 80, 0.12);
        color: #4caf50;
        border: 1px solid rgba(76, 175, 80, 0.25);
    }
    .pill-confirmed .status-dot {
        background: #4caf50;
    }
    .pill-completed {
        background: rgba(142, 133, 123, 0.12);
        color: #8e857b;
        border: 1px solid rgba(142, 133, 123, 0.25);
    }
    .pill-completed .status-dot {
        background: #8e857b;
    }
    .pill-cancelled {
        background: rgba(244, 67, 54, 0.12);
        color: #f44336;
        border: 1px solid rgba(244, 67, 54, 0.25);
    }
    .pill-cancelled .status-dot {
        background: #f44336;
    }
    .btn-book {
        background: #d8b67a;
        color: #120e0c;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: bold;
        text-align: center;
        transition: all 0.3s;
        display: block;
    }
    .btn-book:hover {
        background: #eacc95;
        box-shadow: 0 5px 15px rgba(216, 182, 122, 0.25);
    }
    .history-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 14px;
        justify-content: center;
        border-left: 1px solid rgba(216, 182, 122, 0.15);
        padding-left: 24px;
    }
    @media (max-width: 768px) {
        .history-actions {
            border-left: none;
            border-top: 1px solid rgba(216, 182, 122, 0.15);
            padding-left: 0;
            padding-top: 16px;
            align-items: flex-start;
        }
    }
    @keyframes pulse {
        0% { transform: scale(0.95); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.5; }
    }
</style>

<div style="min-height:100vh; background:linear-gradient(rgba(10,8,7,0.85), rgba(10,8,7,0.92)), url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=2000'); background-size:cover; background-position:center; padding:60px 40px;">

    <div style="max-width:1200px; margin:auto; color:white;">

        {{-- Session Success Alert --}}
        @if(session('success'))
            <div style="background: rgba(216, 182, 122, 0.12); border: 1px solid rgba(216, 182, 122, 0.3); color: #d8b67a; padding: 18px 24px; border-radius: 16px; margin-bottom: 30px; font-weight: bold; display: flex; align-items: center; gap: 12px;">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Admin Hero Banner --}}
        <div class="hero-glass-card" style="margin-bottom: 40px; max-width: 100%;">
            <div class="hero-grid-layout" style="align-items: flex-start;">
                <div class="hero-welcome-section">
                    <p style="color:#d8b67a; letter-spacing:4px; font-size:12px; font-weight:bold; margin: 0 0 12px 0; text-transform: uppercase;">
                        So Cut Studio Admin Panel
                    </p>
                    <h1 style="font-size:46px; font-weight:400; margin:0 0 15px 0; line-height: 1.2; color: white;">
                        Dashboard Overview
                    </h1>
                    <p style="color:#d6cfc7; font-size:16px; margin:0; line-height:1.7; max-width:650px;">
                        Selamat datang di konsol administrasi eksekutif. Kelola menu perawatan, atur database stylist, serta setujui atau tolak janji temu pelanggan secara instan dari satu halaman terintegrasi.
                    </p>
                </div>
                
                <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; justify-content: flex-start; height: 100%;">
                    <div style="background: rgba(216, 182, 122, 0.08); border: 1px solid rgba(216, 182, 122, 0.2); border-radius: 14px; padding: 12px 20px; text-align: right;">
                        <div style="color: #d8b67a; font-size: 11px; font-weight: bold; letter-spacing: 2px; text-transform: uppercase;">Tanggal Hari Ini</div>
                        <div style="color: #fff; font-size: 16px; font-weight: 600; margin-top: 4px;">{{ now()->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Summary Cards Grid --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 50px;">
            <!-- Stat card: Services -->
            <a href="{{ route('admin.services.index') }}" style="text-decoration: none;" class="hero-stat-card">
                <div class="hero-stat-info">
                    <span class="hero-stat-label">Total Layanan</span>
                    <span class="hero-stat-value">{{ $services->count() }}</span>
                </div>
                <div class="hero-stat-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.121 14.121L19 19m-4.879-4.879L14.12 12.12M19 19a2 2 0 11-2.828-2.828L19 19zM10.828 10.828a4 4 0 11-5.656-5.656 4 4 0 015.656 5.656zm0 0l-5.656 5.656m1.414 1.414L10.828 15M15 10a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </a>
            
            <!-- Stat card: Stylists -->
            <a href="{{ route('admin.stylists.index') }}" style="text-decoration: none;" class="hero-stat-card">
                <div class="hero-stat-info">
                    <span class="hero-stat-label">Stylist Aktif</span>
                    <span class="hero-stat-value">{{ $stylists->count() }}</span>
                </div>
                <div class="hero-stat-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </a>

            <!-- Stat card: Appointments -->
            <a href="{{ route('admin.appointments.index') }}" style="text-decoration: none;" class="hero-stat-card">
                <div class="hero-stat-info">
                    <span class="hero-stat-label">Total Booking</span>
                    <span class="hero-stat-value">{{ $appointments->count() }}</span>
                </div>
                <div class="hero-stat-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </a>

            <!-- Stat card: Pending Appointments -->
            <a href="{{ route('admin.appointments.index') }}" style="text-decoration: none;" class="hero-stat-card" style="border-color: rgba(255, 152, 0, 0.3) !important;">
                <div class="hero-stat-info">
                    <span class="hero-stat-label" style="color: #ff9800 !important;">Pending Approval</span>
                    <span class="hero-stat-value" style="color: #ff9800 !important;">{{ $appointments->where('status', 'pending')->count() }}</span>
                </div>
                <div class="hero-stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #ff9800 !important;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </a>
        </div>

        {{-- Core Management Sections Grid --}}
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:28px; margin-bottom: 70px;">

            <!-- services Card -->
            <a href="{{ route('admin.services.index') }}" style="position:relative; overflow:hidden; min-height:300px; border-radius:24px; padding:34px; text-decoration:none; color:white; background:linear-gradient(rgba(20,17,15,0.7), rgba(20,17,15,0.95)), url('https://images.unsplash.com/photo-1562322140-8baeececf3df?q=80&w=800'); background-size:cover; background-position:center; box-shadow:0 20px 45px rgba(0,0,0,0.45); border:1px solid rgba(216,182,122,0.2) !important; transition: all 0.3s;" onmouseover="this.style.borderColor='#d8b67a'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='rgba(216,182,122,0.2)'; this.style.transform='none'">
                <div style="width:56px; height:56px; border-radius:14px; background:rgba(216,182,122,0.15); color:#d8b67a; display:flex; align-items:center; justify-content:center;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.121 14.121L19 19m-4.879-4.879L14.12 12.12M19 19a2 2 0 11-2.828-2.828L19 19zM10.828 10.828a4 4 0 11-5.656-5.656 4 4 0 015.656 5.656zm0 0l-5.656 5.656m1.414 1.414L10.828 15M15 10a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>

                <h2 style="font-family:'Poppins', sans-serif; font-size:32px; font-weight:400; margin:50px 0 12px; color:#d8b67a;">
                    Services
                </h2>

                <p style="color:#c4bbb0; line-height:1.7; font-size: 14.5px; margin-bottom: 20px;">
                    Kelola menu perawatan rambut salon, deskripsi, durasi pengerjaan, dan tabel harga.
                </p>

                <span style="display:inline-block; color:#d8b67a; font-weight:bold; letter-spacing:1px; font-size: 13.5px;">
                    OPEN SERVICES &rarr;
                </span>
            </a>

            <!-- stylists Card -->
            <a href="{{ route('admin.stylists.index') }}" style="position:relative; overflow:hidden; min-height:300px; border-radius:24px; padding:34px; text-decoration:none; color:white; background:linear-gradient(rgba(20,17,15,0.7), rgba(20,17,15,0.95)), url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?q=80&w=800'); background-size:cover; background-position:center; box-shadow:0 20px 45px rgba(0,0,0,0.45); border:1px solid rgba(216,182,122,0.2) !important; transition: all 0.3s;" onmouseover="this.style.borderColor='#d8b67a'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='rgba(216,182,122,0.2)'; this.style.transform='none'">
                <div style="width:56px; height:56px; border-radius:14px; background:rgba(216,182,122,0.15); color:#d8b67a; display:flex; align-items:center; justify-content:center;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>

                <h2 style="font-family:'Poppins', sans-serif; font-size:32px; font-weight:400; margin:50px 0 12px; color:#d8b67a;">
                    Stylists
                </h2>

                <p style="color:#c4bbb0; line-height:1.7; font-size: 14.5px; margin-bottom: 20px;">
                    Kelola data profil penata rambut (stylist), keahlian khusus, gender, dan foto galeri mereka.
                </p>

                <span style="display:inline-block; color:#d8b67a; font-weight:bold; letter-spacing:1px; font-size: 13.5px;">
                    OPEN STYLISTS &rarr;
                </span>
            </a>

            <!-- appointments Card -->
            <a href="{{ route('admin.appointments.index') }}" style="position:relative; overflow:hidden; min-height:300px; border-radius:24px; padding:34px; text-decoration:none; color:white; background:linear-gradient(rgba(20,17,15,0.7), rgba(20,17,15,0.95)), url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=800'); background-size:cover; background-position:center; box-shadow:0 20px 45px rgba(0,0,0,0.45); border:1px solid rgba(216,182,122,0.2) !important; transition: all 0.3s;" onmouseover="this.style.borderColor='#d8b67a'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='rgba(216,182,122,0.2)'; this.style.transform='none'">
                <div style="width:56px; height:56px; border-radius:14px; background:rgba(216,182,122,0.15); color:#d8b67a; display:flex; align-items:center; justify-content:center;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>

                <h2 style="font-family:'Poppins', sans-serif; font-size:32px; font-weight:400; margin:50px 0 12px; color:#d8b67a;">
                    Appointments
                </h2>

                <p style="color:#c4bbb0; line-height:1.7; font-size: 14.5px; margin-bottom: 20px;">
                    Lihat jadwal pemesanan masuk dari customer, status persetujuan, dan kunjungan salon.
                </p>

                <span style="display:inline-block; color:#d8b67a; font-weight:bold; letter-spacing:1px; font-size: 13.5px;">
                    OPEN BOOKINGS &rarr;
                </span>
            </a>

        </div>

        {{-- Recent Appointments Section --}}
        <div>
            <h2 class="section-title" style="margin-bottom: 30px;">Recent Appointments</h2>

            <div class="history-list">

                @forelse($appointments->take(10) as $appointment)

                    <div class="history-card {{ $appointment->status === 'pending' ? 'card-pending' : '' }}" style="grid-template-columns: 2.2fr 1fr;">

                        {{-- Appointment details --}}
                        <div class="history-info" style="gap: 12px 30px;">
                            <h3 class="history-title">
                                {{ $appointment->service->name ?? '-' }}
                            </h3>

                            <div class="meta-item">
                                Customer: <strong style="color: #faf9f8;">{{ $appointment->user->name ?? '-' }}</strong>
                            </div>

                            <div class="meta-item">
                                Stylist: <strong style="color: #faf9f8;">{{ $appointment->stylist->name ?? '-' }}</strong>
                            </div>

                            <div class="meta-item">
                                Tanggal: <strong style="color: #faf9f8;">{{ $appointment->appointment_date }}</strong>
                            </div>

                            <div class="meta-item">
                                Jam: <strong style="color: #faf9f8;">{{ $appointment->appointment_time }} WIB</strong>
                            </div>

                            <div class="meta-item" style="grid-column: 1 / -1; margin-top: 6px; border-top: 1px dashed rgba(216,182,122,0.15); padding-top: 10px;">
                                Pembayaran: 
                                @if($appointment->latestPayment)
                                    <strong style="color: #d8b67a;">Rp {{ number_format($appointment->latestPayment->amount, 0, ',', '.') }} ({{ strtoupper($appointment->latestPayment->payment_method) }})</strong>
                                    - 
                                    @if($appointment->latestPayment->status === 'completed')
                                        <span style="color:#4caf50; font-weight:bold;">✓ Selesai</span>
                                    @elseif($appointment->latestPayment->status === 'pending')
                                        <span style="color:#ff9800; font-weight:bold;">⏳ Menunggu</span>
                                    @else
                                        <span style="color:#f44336; font-weight:bold;">✕ Dibatalkan</span>
                                    @endif
                                    -
                                    <a href="{{ route('payments.show', $appointment->latestPayment->id) }}" style="color: #d8b67a; text-decoration: underline; font-size: 13px; font-weight: bold;">Lihat Bukti</a>
                                @else
                                    <span style="color: #8e857b; font-style: italic;">Belum ada pembayaran</span>
                                @endif
                            </div>

                            <div class="meta-item" style="grid-column: 1 / -1; margin-top: 6px; border-top: 1px dashed rgba(216,182,122,0.08); padding-top: 6px;">
                                Catatan: <span style="color: #faf9f8; font-style: italic;">{{ $appointment->notes ?: 'Tidak ada catatan.' }}</span>
                            </div>
                        </div>

                        {{-- Status Badge & Action Buttons --}}
                        <div class="history-actions">
                            {{-- Status Pill --}}
                            <div>
                                @if($appointment->status === 'completed')
                                    <span class="status-pill pill-completed"><span class="status-dot"></span>Completed</span>
                                @elseif($appointment->status === 'approved' || $appointment->status === 'confirmed')
                                    <span class="status-pill pill-confirmed"><span class="status-dot"></span>Approved</span>
                                @elseif($appointment->status === 'rejected' || $appointment->status === 'cancelled')
                                    <span class="status-pill pill-cancelled"><span class="status-dot"></span>Rejected</span>
                                @else
                                    <span class="status-pill pill-pending"><span class="status-dot"></span>Pending</span>
                                @endif
                            </div>

                            {{-- Quick Actions for Pending --}}
                            @if($appointment->status === 'pending')
                                <div style="display: flex; flex-direction: column; gap: 8px; width: 100%;">
                                    <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn-book" style="padding: 8px 16px; font-size: 13px; cursor: pointer; border: none; width: 100%; text-align: center;">
                                            ✓ Approve
                                            @if($appointment->latestPayment)
                                                <span style="display:block; font-size:10px; opacity:0.75; font-weight:normal;">+ Konfirmasi Pembayaran</span>
                                            @endif
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" onclick="return confirm('Yakin ingin menolak appointment ini?')" style="background: rgba(244, 67, 54, 0.1); border: 1px solid rgba(244, 67, 54, 0.3); color: #f44336; padding: 8px 16px; border-radius: 10px; font-weight: bold; font-size: 13px; cursor: pointer; transition: all 0.3s; width: 100%; text-align: center;" onmouseover="this.style.background='rgba(244, 67, 54, 0.18)'" onmouseout="this.style.background='rgba(244, 67, 54, 0.1)'">
                                            ✕ Reject
                                            @if($appointment->latestPayment)
                                                <span style="display:block; font-size:10px; opacity:0.75; font-weight:normal;">+ Batalkan Pembayaran</span>
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                    </div>

                @empty

                    <div style="background:#14110f; border-radius:18px; padding:40px; text-align:center; color:#8e857b; border: 1px dashed rgba(216,182,122,0.25);">
                        <p style="font-size:16px; margin:0;">Belum ada riwayat booking appointment customer.</p>
                    </div>

                @endforelse

            </div>
        </div>

    </div>

</div>

@endsection