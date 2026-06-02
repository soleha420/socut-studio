@extends('layouts.customer')

@section('content')
<style>
    .dashboard-hero {
        min-height: 45vh;
        background: linear-gradient(rgba(10, 8, 7, 0.7), rgba(10, 8, 7, 0.9)), 
                    url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=2000');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        padding: 60px 40px;
        position: relative;
    }
    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 40px 20px;
            min-height: 35vh;
        }
    }
    .hero-glass-card {
        background: rgba(20, 17, 15, 0.65);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(216, 182, 122, 0.15);
        border-radius: 24px;
        padding: 40px;
        max-width: 800px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
    }
    @media (max-width: 576px) {
        .hero-glass-card {
            padding: 24px;
        }
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
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 20px;
    }
    .service-card {
        background: #14110f;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(216, 182, 122, 0.12);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .service-card:hover {
        transform: translateY(-5px);
        border-color: #d8b67a;
        box-shadow: 0 20px 45px rgba(216, 182, 122, 0.08);
    }
    .service-img-wrapper {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    .service-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .service-card:hover .service-img {
        transform: scale(1.06);
    }
    .service-price-tag {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(10, 8, 7, 0.85);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(216, 182, 122, 0.3);
        color: #d8b67a;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: bold;
        font-size: 14px;
    }
    .service-info {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .service-name {
        font-family: 'Poppins', sans-serif;
        font-size: 22px;
        color: #d8b67a;
        margin: 0 0 10px 0;
    }
    .service-desc {
        color: #c4bbb0;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
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
    @keyframes pulse {
        0% { transform: scale(0.95); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.5; }
    }
</style>

{{-- HERO SECTION --}}
<div class="dashboard-hero" style="justify-content: center;">
    <div class="hero-glass-card">
        <div class="hero-grid-layout">
            <!-- Left Column: Welcome -->
            <div class="hero-welcome-section">
                <p style="color:#d8b67a; letter-spacing:4px; font-size:12px; font-weight:bold; margin: 0 0 12px 0; text-transform: uppercase;">
                    So Cut Studio Customer Workspace
                </p>
                <h1 style="font-size:46px; font-weight:400; margin:0 0 20px 0; line-height: 1.2; color: white;">
                    Selamat Datang,<br>
                    <span style="color:#d8b67a; font-family: 'Poppins', sans-serif;">{{ Auth::user()->name }}</span>
                </h1>
                <p style="color:#d6cfc7; font-size:16px; margin:0; line-height:1.7; max-width:600px;">
                    Nikmati layanan perawatan rambut premium kami. Booking stylist favorit Anda dengan cepat dan mudah lewat dashboard eksklusif ini. Jelajahi menu perawatan kami di bawah dan mulailah perjalanan penampilan baru Anda.
                </p>
            </div>
            
            <!-- Right Column: Booking Statistics Panel -->
            <div class="hero-stats-panel">
                <!-- Total Booking Stat -->
                <div class="hero-stat-card">
                    <div class="hero-stat-info">
                        <span class="hero-stat-label">Total Booking</span>
                        <span class="hero-stat-value">{{ $appointments->count() }}</span>
                    </div>
                    <div class="hero-stat-icon">📅</div>
                </div>
                
                <!-- Pending Booking Stat -->
                <div class="hero-stat-card">
                    <div class="hero-stat-info">
                        <span class="hero-stat-label">Menunggu Persetujuan</span>
                        <span class="hero-stat-value">{{ $appointments->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="hero-stat-icon">⏳</div>
                </div>
                
                <!-- Completed Booking Stat -->
                <div class="hero-stat-card">
                    <div class="hero-stat-info">
                        <span class="hero-stat-label">Booking Selesai</span>
                        <span class="hero-stat-value">{{ $appointments->where('status', 'completed')->count() }}</span>
                    </div>
                    <div class="hero-stat-icon">✓</div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="max-width: 1200px; margin: 50px auto; padding: 0 20px;">

    {{-- ALERT NOTIFICATION --}}
    @if(session('success'))
        <div style="background: rgba(216, 182, 122, 0.12); border: 1px solid rgba(216, 182, 122, 0.3); color: #d8b67a; padding: 18px 24px; border-radius: 16px; margin-bottom: 40px; font-weight: bold; display: flex; align-items: center; gap: 12px;">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- SECTION 1: SERVICES --}}
    <div style="margin-bottom: 70px;">
        <h2 class="section-title">Layanan Salon</h2>
        
        <div class="services-grid">
            @foreach ($services as $service)
                <div class="service-card">
                    <div class="service-img-wrapper">
                        @php

                            $defaultImages = [
                                'haircut' => 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=1200',
                                'hair coloring' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=1200',
                                'creambath' => 'https://images.unsplash.com/photo-1562322140-8baeececf3df?w=1200',
                                'hair spa' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=1200',
                            ];

                            $serviceName = strtolower(trim($service->name));

                            $imageUrl = $defaultImages[$serviceName]
                                ?? 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=1200';

                        @endphp

                        @if ($service->image)

                            <img src="{{ asset('storage/' . $service->image) }}"
                                alt="{{ $service->name }}"
                                class="service-img">

                        @else

                            <img src="{{ $imageUrl }}"
                                alt="{{ $service->name }}"
                                class="service-img">

                        @endif
                        <span class="service-price-tag">
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="service-info">
                        <h3 class="service-name">{{ $service->name }}</h3>
                        <p class="service-desc">{{ $service->description }}</p>
                        <a href="{{ route('customer.booking', ['service_id' => $service->id]) }}" class="btn-book">
                            Book Service
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- SECTION 2: BOOKING HISTORY --}}
    <div>
        <h2 class="section-title">Riwayat Pemesanan</h2>
        
        <div class="history-list">
            @forelse($appointments as $appointment)
                <div class="history-card">
                    {{-- Left side info --}}
                    <div class="history-info">
                        <h3 class="history-title">
                            {{ $appointment->service->name ?? 'Layanan Salon' }}
                        </h3>
                        
                        <div class="meta-item">
                            Stylist: <strong>{{ $appointment->stylist->name ?? '-' }}</strong>
                        </div>
                        <div class="meta-item">
                            Tanggal: <strong>{{ $appointment->appointment_date }}</strong>
                        </div>
                        <div class="meta-item">
                            Jam: <strong>{{ $appointment->appointment_time }} WIB</strong>
                        </div>
                        <div class="meta-item">
                            Catatan: <strong>{{ $appointment->notes ?: '-' }}</strong>
                        </div>

                        {{-- Payment Badge --}}
                        <div class="meta-item" style="grid-column: 1 / -1; margin-top: 8px; border-top: 1px dashed rgba(216,182,122,0.15); padding-top: 10px;">
                            Status Pembayaran:
                            @php
                                $latestPayment = $appointment->latestPayment()->first();
                            @endphp

                            @if($latestPayment)
                                @if($latestPayment->status === 'completed')
                                    <span style="color: #4caf50; font-weight: bold; margin-left: 6px;">✓ Lunas (Completed)</span>
                                @elseif($latestPayment->status === 'pending')
                                    <span style="color: #ff9800; font-weight: bold; margin-left: 6px;">⏳ Menunggu Konfirmasi (Pending)</span>
                                @else
                                    <span style="color: #f44336; font-weight: bold; margin-left: 6px;">✕ Dibatalkan</span>
                                @endif
                            @else
                                <span style="color: #8e857b; font-weight: bold; margin-left: 6px;">⚠ Belum Dibayar</span>
                            @endif
                        </div>
                    </div>

                    {{-- Right side status & action buttons --}}
                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 14px; justify-content: center;">
                        {{-- Appointment status pill --}}
                        <div>
                            @if($appointment->status === 'completed')
                                <span class="status-pill pill-completed"><span class="status-dot"></span>Completed</span>
                            @elseif($appointment->status === 'confirmed' || $appointment->status === 'approved')
                                <span class="status-pill pill-confirmed"><span class="status-dot"></span>Confirmed</span>
                            @elseif($appointment->status === 'cancelled' || $appointment->status === 'rejected')
                                <span class="status-pill pill-cancelled"><span class="status-dot"></span>Cancelled</span>
                            @else
                                <span class="status-pill pill-pending"><span class="status-dot"></span>Pending</span>
                            @endif
                        </div>

                        {{-- Payment Action Buttons --}}
                        <div style="width: 100%; display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                            @if($appointment->status == 'pending' || $appointment->status == 'approved' || $appointment->status == 'confirmed')
                                @if(!$latestPayment)
                                    <a href="{{ route('payments.create', ['appointment_id' => $appointment->id]) }}" style="background:#d8b67a; color:#120e0c; text-decoration:none; padding:10px 18px; border-radius:8px; font-weight:bold; font-size:13px; text-align:center; display:inline-block; transition:all 0.3s;" onmouseover="this.style.background='#eacc95'" onmouseout="this.style.background='#d8b67a'">
                                        💳 Bayar Sekarang
                                    </a>
                                @elseif($latestPayment->status === 'pending')
                                    <a href="{{ route('payments.show', $latestPayment->id) }}" style="background:rgba(255, 152, 0, 0.1); border:1px solid rgba(255, 152, 0, 0.3); color:#ff9800; text-decoration:none; padding:9px 18px; border-radius:8px; font-weight:bold; font-size:13px; text-align:center; display:inline-block; transition:all 0.3s;" onmouseover="this.style.background='rgba(255, 152, 0, 0.18)'" onmouseout="this.style.background='rgba(255, 152, 0, 0.1)'">
                                        ⏳ Lihat Detail Pembayaran
                                    </a>
                                @endif
                            @endif

                            {{-- Cancel Booking Button --}}
                            @if($appointment->status == 'pending')
                                <form action="{{ route('customer.booking.cancel', $appointment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:rgba(244, 67, 54, 0.1); border:1px solid rgba(244, 67, 54, 0.3); color:#f44336; padding:9px 18px; border-radius:8px; font-weight:bold; font-size:13px; cursor:pointer; width:100%; transition:all 0.3s;" onmouseover="this.style.background='rgba(244, 67, 54, 0.18)'" onmouseout="this.style.background='rgba(244, 67, 54, 0.1)'">
                                        Batalkan Booking
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="background:#14110f; border-radius:18px; padding:40px; text-align:center; color:#8e857b; border: 1px dashed rgba(216,182,122,0.25);">
                    <p style="font-size:16px; margin:0;">Belum ada riwayat booking appointment.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection