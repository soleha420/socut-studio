<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>So Cut Studio - Pembayaran</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="margin:0; font-family:'Poppins', sans-serif; background:#0f0d0c;">

<nav x-data="{ mobileOpen: false }" style="
    position:sticky;
    top:0;
    z-index:999;
    backdrop-filter:blur(14px);
    background:rgba(10,8,7,0.92);
    border-bottom:1px solid rgba(216,182,122,0.18);
    padding:16px 40px;
">
    <div class="nav-layout">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="nav-brand-logo">
            <div style="font-family:'Playfair Display', Georgia, serif; font-size:32px; font-weight:700; color:#d8b67a; letter-spacing:-0.5px; display:flex; align-items:center; gap:10px;">
                <span class="logo-text-serif" style="font-style:italic;">So</span>
                <span style="color:#ffffff; font-size:13px; letter-spacing:4px; font-family:'Poppins', sans-serif; font-weight:400; border-left:1px solid rgba(216,182,122,0.3); padding-left:12px; text-transform:uppercase; margin-top:4px;">Cut Studio</span>
            </div>
        </a>

        <!-- Middle links (Left-aligned next to logo, dynamic by role) -->
        <div class="desktop-nav nav-links-group" style="margin-left: 40px; flex-grow: 1;">
            @if(Auth::user()->role === 'admin')
                <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="/admin/services" class="nav-link {{ request()->is('admin/services*') ? 'active' : '' }}">Services</a>
                <a href="/admin/stylists" class="nav-link {{ request()->is('admin/stylists*') ? 'active' : '' }}">Stylists</a>
                <a href="/admin/appointments" class="nav-link {{ request()->is('admin/appointments*') ? 'active' : '' }}">Appointments</a>
                <a href="{{ route('payments.index') }}" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">Pembayaran</a>
            @else
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('customer.stylists') }}" class="nav-link {{ request()->routeIs('customer.stylists') ? 'active' : '' }}">Stylists</a>
                <a href="{{ route('payments.index') }}" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">Pembayaran</a>
            @endif
        </div>

        <!-- User Dropdown (Desktop) -->
        <div class="desktop-nav user-dropdown-container" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" class="user-dropdown-btn">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-info-text">
                    <div class="user-display-name">{{ Auth::user()->name }}</div>
                    <div class="user-display-role">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Customer' }}</div>
                </div>
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="color:#d8b67a; transition: transform 0.3s;" :style="open ? 'transform: rotate(180deg)' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Content -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="user-dropdown-menu"
                 style="display: none;">
                <div class="user-dropdown-header">
                    <div class="user-dropdown-name">{{ Auth::user()->name }}</div>
                    <div class="user-dropdown-email">{{ Auth::user()->email }}</div>
                </div>
                <div class="user-dropdown-body">
                    <a href="{{ route('profile.edit') }}" class="user-dropdown-item">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Ubah Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="user-dropdown-item logout">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar (Logout)
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hamburger menu trigger (Mobile) -->
        <button @click="mobileOpen = !mobileOpen" class="mobile-nav-toggle">
            <svg x-show="!mobileOpen" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg x-show="mobileOpen" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div x-show="mobileOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-4"
         class="mobile-menu-dropdown"
         style="display: none;">
        <div class="mobile-menu-links">
            @if(Auth::user()->role === 'admin')
                <a href="/admin/dashboard" class="mobile-nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="/admin/services" class="mobile-nav-link {{ request()->is('admin/services*') ? 'active' : '' }}">Services</a>
                <a href="/admin/stylists" class="mobile-nav-link {{ request()->is('admin/stylists*') ? 'active' : '' }}">Stylists</a>
                <a href="/admin/appointments" class="mobile-nav-link {{ request()->is('admin/appointments*') ? 'active' : '' }}">Appointments</a>
                <a href="{{ route('payments.index') }}" class="mobile-nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">Pembayaran</a>
            @else
                <a href="{{ route('dashboard') }}" class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('customer.stylists') }}" class="mobile-nav-link {{ request()->routeIs('customer.stylists') ? 'active' : '' }}">Stylists</a>
                <a href="{{ route('payments.index') }}" class="mobile-nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">Pembayaran</a>
            @endif
        </div>
        <div class="mobile-user-panel">
            <div style="display: flex; align-items: center; gap: 12px; padding: 0 16px;">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="user-display-name" style="font-size: 15px;">{{ Auth::user()->name }}</div>
                    <div style="color: var(--text-low); font-size: 12px;">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 10px; padding: 0 8px;">
                <a href="{{ route('profile.edit') }}" class="user-dropdown-item" style="justify-content: center; background: rgba(216,182,122,0.1); border: 1px solid rgba(216,182,122,0.2);">
                    Ubah Profil
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0; flex-grow: 1;">
                    @csrf
                    <button type="submit" class="user-dropdown-item logout" style="justify-content: center; background: rgba(244,67,54,0.1); border: 1px solid rgba(244,67,54,0.2);">
                        Logout
                      </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main>
    @yield('content')
    {{ $slot ?? '' }}
</main>

</body>
</html>