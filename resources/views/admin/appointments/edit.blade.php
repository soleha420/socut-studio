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
        max-width:800px;
        margin:auto;
        background:rgba(18,15,13,0.92);
        padding:40px;
        border-radius:28px;
        border:1px solid rgba(216,182,122,0.25);
    ">

        <h1 style="
            color:#d8b67a;
            font-family:'Poppins', sans-serif;
            font-size:42px;
            margin-bottom:30px;
        ">
            Edit Appointment
        </h1>

        <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom:22px;">
                <label>Customer</label>
                <select name="user_id" style="width:100%; margin-top:10px; padding:14px; border-radius:12px; background:#2a221d; color:white; border:none;">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $appointment->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:22px;">
                <label>Service</label>
                <select name="service_id" style="width:100%; margin-top:10px; padding:14px; border-radius:12px; background:#2a221d; color:white; border:none;">
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{ $appointment->service_id == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:22px;">
                <label>Stylist</label>
                <select name="stylist_id" style="width:100%; margin-top:10px; padding:14px; border-radius:12px; background:#2a221d; color:white; border:none;">
                    @foreach ($stylists as $stylist)
                        <option value="{{ $stylist->id }}" {{ $appointment->stylist_id == $stylist->id ? 'selected' : '' }}>
                            {{ $stylist->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:22px;">
                <label>Appointment Date</label>
                <input
                    type="date"
                    name="appointment_date"
                    value="{{ $appointment->appointment_date }}"
                    style="width:100%; margin-top:10px; padding:14px; border-radius:12px; background:#2a221d; color:white; border:none;"
                >
            </div>

            <div style="margin-bottom:22px;">
                <label>Appointment Time</label>
                <input
                    type="time"
                    name="appointment_time"
                    value="{{ $appointment->appointment_time }}"
                    style="width:100%; margin-top:10px; padding:14px; border-radius:12px; background:#2a221d; color:white; border:none;"
                >
            </div>

            <div style="margin-bottom:22px;">
                <label>Status</label>
                <select name="status" style="width:100%; margin-top:10px; padding:14px; border-radius:12px; background:#2a221d; color:white; border:none;">
                    <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>
                        Approved
                    </option>

                    <option value="rejected" {{ $appointment->status == 'rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>

                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                </select>
            </div>

            <div style="margin-bottom:30px;">
                <label>Notes</label>
                <textarea
                    name="notes"
                    rows="4"
                    style="width:100%; margin-top:10px; padding:14px; border-radius:12px; background:#2a221d; color:white; border:none;"
                >{{ $appointment->notes }}</textarea>
            </div>

            <button type="submit" style="
                background:#d8b67a;
                color:#1f1a17;
                border:none;
                padding:14px 28px;
                border-radius:14px;
                font-weight:bold;
                cursor:pointer;
            ">
                Update Appointment
            </button>

            <a href="{{ route('admin.appointments.index') }}" style="
                margin-left:12px;
                color:#d8b67a;
                text-decoration:none;
                font-weight:bold;
            ">
                Back
            </a>

        </form>

    </div>

</div>

@endsection