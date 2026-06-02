<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - So Cut Studio</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="
    margin:0;
    font-family:'Poppins', sans-serif;
    background:
    linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
    url('https://images.unsplash.com/photo-1560066984-138dadb4c035');
    background-size:cover;
    background-position:center;
    background-attachment:fixed;
">

<div style="
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px;
">

    <div style="
        width:950px;
        display:flex;
        border-radius:28px;
        overflow:hidden;
        background:rgba(255,255,255,0.95);
        box-shadow:0 25px 60px rgba(0,0,0,0.35);
    ">

        <!-- LEFT SIDE -->
        <div style="
            width:45%;
            background:
            linear-gradient(rgba(0,0,0,0.72), rgba(0,0,0,0.72)),
            url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f');
            background-size:cover;
            background-position:center;
            color:white;
            padding:90px 45px 60px;
        ">

            <h1 style="margin:0; line-height:0.9;">
                <span style="
                    display:block;
                    font-family:Georgia, serif;
                    font-size:90px;
                    color:#d8b67a;
                    font-style:italic;
                    font-weight:400;
                ">
                    So
                </span>

                <span style="
                    display:block;
                    font-size:54px;
                    color:white;
                    font-weight:bold;
                    letter-spacing:1px;
                ">
                    Cut Studio
                </span>
            </h1>

            <p style="color:#d8b67a; margin-top:25px; font-size:20px;">
                Unisex Hair & Grooming
            </p>

            <div style="
                width:80px;
                height:4px;
                background:#d8b67a;
                margin:30px 0;
                border-radius:10px;
            "></div>

            <p style="line-height:2; color:#f3f3f3; font-size:16px;">
                Don’t worry, we’ll help you access your account again so you can continue booking your favorite salon services.
            </p>

            <div style="margin-top:55px;">
                <p>✂ &nbsp; Modern Hair Styling</p>
                <p>★ &nbsp; Premium Salon Experience</p>
                <p>✔ &nbsp; Fast Online Reservation</p>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div style="
            width:55%;
            padding:65px 60px;
            background:white;
        ">

            <h2 style="
                font-size:40px;
                margin-bottom:12px;
                color:#1f1a17;
            ">
                Forgot Password?
            </h2>

            <p style="
                color:#777;
                margin-bottom:35px;
                font-size:15px;
                line-height:1.8;
            ">
                No problem. Enter your email address and we will send you a password reset link.
            </p>

            <!-- Session Status -->
            <x-auth-session-status
                class="mb-4"
                :status="session('status')"
            />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- EMAIL -->
                <div style="margin-bottom:35px;">

                    <label style="
                        display:block;
                        margin-bottom:10px;
                        color:#333;
                        font-weight:600;
                    ">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus

                        style="
                            width:100%;
                            padding:16px;
                            border:1px solid #ddd;
                            border-radius:15px;
                            outline:none;
                            font-size:15px;
                            box-sizing:border-box;
                        "
                    >

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"
                    />

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"

                    style="
                        width:100%;
                        padding:16px;
                        background:#1f1a17;
                        color:white;
                        border:none;
                        border-radius:15px;
                        font-size:16px;
                        cursor:pointer;
                        font-weight:bold;
                        letter-spacing:1px;
                    "

                    onmouseover="this.style.background='#b3874b'"
                    onmouseout="this.style.background='#1f1a17'"
                >
                    EMAIL PASSWORD RESET LINK
                </button>

            </form>

            <p style="
                text-align:center;
                margin-top:35px;
                color:#777;
                font-size:15px;
            ">
                Remember your password?

                <a
                    href="{{ route('login') }}"

                    style="
                        color:#b3874b;
                        text-decoration:none;
                        font-weight:bold;
                    "
                >
                    Login here
                </a>
            </p>

        </div>

    </div>

</div>

</body>
</html>