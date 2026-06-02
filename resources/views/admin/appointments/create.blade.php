@extends('layouts.admin')

@section('content')

<div style="
    min-height:100vh;
    background:#0f0d0c;
    color:white;
    padding:60px;
    font-family:'Poppins', sans-serif;
">

    <div style="
        max-width:850px;
        margin:auto;
        background:rgba(18,15,13,0.92);
        border:1px solid rgba(216,182,122,0.22);
        border-radius:32px;
        padding:45px;
        box-shadow:0 25px 60px rgba(0,0,0,0.35);
    ">

        <h1 style="
            color:#d8b67a;
            font-family:'Poppins', sans-serif;
            font-size:48px;
            margin-bottom:10px;
        ">
            Add Appointment
        </h1>

        <p style="
            color:#cfc7bd;
            margin-bottom:38px;
            line-height:1.8;
        ">
            Create new customer appointment and manage salon scheduling.
        </p>

        <form action="{{ route('admin.appointments.store') }}" method="POST">

            @csrf

            {{-- CUSTOMER --}}
            <div style="margin-bottom:24px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    color:#d8b67a;
                    font-weight:bold;
                ">
                    Customer
                </label>

                <select name="user_id" style="
                    width:100%;
                    padding:15px;
                    border-radius:14px;
                    background:#241d19;
                    border:1px solid rgba(216,182,122,0.18);
                    color:white;
                    font-size:15px;
                    outline:none;
                ">

                    <option value="">
                        Choose Customer
                    </option>

                    @foreach ($users as $user)

                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- SERVICE --}}
            <div style="margin-bottom:24px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    color:#d8b67a;
                    font-weight:bold;
                ">
                    Service
                </label>

                <select name="service_id" style="
                    width:100%;
                    padding:15px;
                    border-radius:14px;
                    background:#241d19;
                    border:1px solid rgba(216,182,122,0.18);
                    color:white;
                    font-size:15px;
                    outline:none;
                ">

                    <option value="">
                        Choose Service
                    </option>

                    @foreach ($services as $service)

                        <option value="{{ $service->id }}">
                            {{ $service->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- STYLIST --}}
            <div style="margin-bottom:24px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    color:#d8b67a;
                    font-weight:bold;
                ">
                    Stylist
                </label>

                <select name="stylist_id" style="
                    width:100%;
                    padding:15px;
                    border-radius:14px;
                    background:#241d19;
                    border:1px solid rgba(216,182,122,0.18);
                    color:white;
                    font-size:15px;
                    outline:none;
                ">

                    <option value="">
                        Choose Stylist
                    </option>

                    @foreach ($stylists as $stylist)

                        <option value="{{ $stylist->id }}">
                            {{ $stylist->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- DATE --}}
            <div style="margin-bottom:24px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    color:#d8b67a;
                    font-weight:bold;
                ">
                    Appointment Date
                </label>

                <input
                    type="date"
                    name="appointment_date"
                    style="
                        width:100%;
                        padding:15px;
                        border-radius:14px;
                        background:#241d19;
                        border:1px solid rgba(216,182,122,0.18);
                        color:white;
                        font-size:15px;
                        outline:none;
                    "
                >

            </div>

            {{-- TIME --}}
            <div style="margin-bottom:24px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    color:#d8b67a;
                    font-weight:bold;
                ">
                    Appointment Time
                </label>

                <input
                    type="time"
                    name="appointment_time"
                    style="
                        width:100%;
                        padding:15px;
                        border-radius:14px;
                        background:#241d19;
                        border:1px solid rgba(216,182,122,0.18);
                        color:white;
                        font-size:15px;
                        outline:none;
                    "
                >

            </div>

            {{-- STATUS --}}
            <div style="margin-bottom:24px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    color:#d8b67a;
                    font-weight:bold;
                ">
                    Status
                </label>

                <select name="status" style="
                    width:100%;
                    padding:15px;
                    border-radius:14px;
                    background:#241d19;
                    border:1px solid rgba(216,182,122,0.18);
                    color:white;
                    font-size:15px;
                    outline:none;
                ">

                    <option value="pending">
                        Pending
                    </option>

                    <option value="approved">
                        Approved
                    </option>

                    <option value="completed">
                        Completed
                    </option>

                    <option value="rejected">
                        Rejected
                    </option>

                </select>

            </div>

            {{-- NOTES --}}
            <div style="margin-bottom:34px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    color:#d8b67a;
                    font-weight:bold;
                ">
                    Notes
                </label>

                <textarea
                    name="notes"
                    rows="5"
                    style="
                        width:100%;
                        padding:15px;
                        border-radius:14px;
                        background:#241d19;
                        border:1px solid rgba(216,182,122,0.18);
                        color:white;
                        font-size:15px;
                        outline:none;
                        resize:none;
                    "
                ></textarea>

            </div>

            {{-- BUTTON --}}
            <div style="
                display:flex;
                align-items:center;
                gap:14px;
            ">

                <button type="submit" style="
                    background:#d8b67a;
                    color:#1f1a17;
                    border:none;
                    padding:15px 26px;
                    border-radius:14px;
                    font-weight:bold;
                    font-size:15px;
                    cursor:pointer;
                ">
                    Save Appointment
                </button>

                <a href="{{ route('admin.appointments.index') }}" style="
                    color:#d8b67a;
                    text-decoration:none;
                    font-weight:bold;
                ">
                    Back
                </a>

            </div>

        </form>

    </div>

</div>

@endsection