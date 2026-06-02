<nav x-data="{ open: false }" style="
    position:sticky;
    top:0;
    z-index:999;
    background:rgba(10,8,7,0.92);
    backdrop-filter:blur(14px);
    border-bottom:1px solid rgba(216,182,122,0.15);
">

    <div style="
        max-width:1400px;
        margin:auto;
        padding:22px 55px;
        display:flex;
        justify-content:space-between;
        align-items:center;
    ">

        <!-- LOGO -->
        <div style="
            display:flex;
            align-items:center;
            gap:18px;
        ">

            <a href="{{ route('dashboard') }}" style="text-decoration:none;">

                <div style="
                    font-family:Georgia, serif;
                    font-size:52px;
                    color:#d8b67a;
                    font-style:italic;
                    line-height:0.8;
                ">
                    So
                </div>

                <div style="
                    color:white;
                    letter-spacing:6px;
                    font-size:12px;
                    margin-top:8px;
                ">
                    CUT STUDIO
                </div>

            </a>

        </div>

        <!-- MENU -->
        <div style="
            display:flex;
            align-items:center;
            gap:40px;
        ">

            <a href="{{ route('dashboard') }}" style="
                color:#d8b67a;
                text-decoration:none;
                font-size:17px;
                font-weight:600;
            ">
                Dashboard
            </a>

            <a href="/admin/services" style="
                color:white;
                text-decoration:none;
                font-size:17px;
                transition:0.3s;
            "
            onmouseover="this.style.color='#d8b67a'"
            onmouseout="this.style.color='white'"
            >
                Services
            </a>

            <a href="/admin/stylists" style="
                color:white;
                text-decoration:none;
                font-size:17px;
                transition:0.3s;
            "
            onmouseover="this.style.color='#d8b67a'"
            onmouseout="this.style.color='white'"
            >
                Stylists
            </a>

            <a href="/admin/appointments" style="
                color:white;
                text-decoration:none;
                font-size:17px;
                transition:0.3s;
            "
            onmouseover="this.style.color='#d8b67a'"
            onmouseout="this.style.color='white'"
            >
                Appointments
            </a>

        </div>

        <!-- USER -->
        <div style="
            display:flex;
            align-items:center;
            gap:14px;
        ">

            <!-- AVATAR -->
            <div style="
                width:48px;
                height:48px;
                border-radius:50%;
                background:#d8b67a;
                color:#1f1a17;
                display:flex;
                align-items:center;
                justify-content:center;
                font-weight:bold;
                font-size:18px;
            ">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            <!-- PROFILE -->
            <a href="{{ route('profile.edit') }}" style="
                text-decoration:none;
                line-height:1.3;
            ">
                <div style="
                    color:white;
                    font-size:15px;
                    font-weight:600;
                ">
                    {{ Auth::user()->name }}
                </div>

                <div style="
                    color:#b8b8b8;
                    font-size:13px;
                ">
                    View Profile
                </div>
            </a>

            <!-- LOGOUT -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" style="
                    background:#d8b67a;
                    color:#1f1a17;
                    border:none;
                    padding:11px 18px;
                    border-radius:14px;
                    font-weight:bold;
                    cursor:pointer;
                    margin-left:12px;
                    transition:0.3s;
                "
                onmouseover="this.style.background='#f0c97d'"
                onmouseout="this.style.background='#d8b67a'"
                >
                    Logout
                </button>
            </form>

        </div>

    </div>

</nav>