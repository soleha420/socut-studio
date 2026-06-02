@extends('layouts.customer')

@section('content')

<div style="
    min-height:100vh;
    background:
        linear-gradient(rgba(10,8,7,0.86), rgba(10,8,7,0.92)),
        url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f');
    background-size:cover;
    background-position:center;
    font-family:'Poppins', sans-serif;
">

    <div style="
        max-width:760px;
        margin:auto;
        background:rgba(18,15,13,0.9);
        padding:42px;
        border-radius:28px;
        border:1px solid rgba(216,182,122,0.2);
    ">

        <h1 style="
            color:#d8b67a;
            font-family:'Poppins', sans-serif;
            font-size:42px;
            margin-bottom:12px;
        ">
            Booking Appointment
        </h1>

        <p style="color:#bbb; margin-bottom:35px;">
            Complete your booking appointment information.
        </p>

        <form method="POST" action="{{ route('customer.booking.store') }}">
            @csrf

            <div style="margin-bottom:26px;">
                <label>Select Service</label>

                <select name="service_id" required style="
                    width:100%;
                    margin-top:10px;
                    padding:15px;
                    border:none;
                    border-radius:14px;
                    background:#2a221d;
                    color:white;
                ">
                    <option value="">-- Select Service --</option>

                    @foreach($services as $service)
                        <option
                            value="{{ $service->id }}"
                            {{ isset($selectedService) && $selectedService == $service->id ? 'selected' : '' }}
                        >
                            {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:26px;">
                <label>Select Stylist</label>

                <select name="stylist_id" required style="
                    width:100%;
                    margin-top:10px;
                    padding:15px;
                    border:none;
                    border-radius:14px;
                    background:#2a221d;
                    color:white;
                ">
                    <option value="">-- Select Stylist --</option>

                    @foreach($stylists as $stylist)
                        <option value="{{ $stylist->id }}">
                            {{ $stylist->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:26px;">
                <label>Appointment Date</label>

                <input type="date" name="appointment_date" required style="
                    width:100%;
                    margin-top:10px;
                    padding:15px;
                    border:none;
                    border-radius:14px;
                    background:#2a221d;
                    color:white;
                ">
            </div>

            <div style="margin-bottom:26px;">
                <label>Appointment Time</label>

                <input type="time" name="appointment_time" required style="
                    width:100%;
                    margin-top:10px;
                    padding:15px;
                    border:none;
                    border-radius:14px;
                    background:#2a221d;
                    color:white;
                ">
            </div>

            <div style="margin-bottom:30px;">
                <label>Notes</label>

                <textarea name="notes" rows="4" style="
                    width:100%;
                    margin-top:10px;
                    padding:15px;
                    border:none;
                    border-radius:14px;
                    background:#2a221d;
                    color:white;
                    resize:none;
                "></textarea>
            </div>

            <button style="
                background:#d8b67a;
                color:#1f1a17;
                border:none;
                padding:14px 28px;
                border-radius:14px;
                font-weight:bold;
                cursor:pointer;
            ">
                Submit Booking
            </button>

        </form>

    </div>

</div>

@endsection