@extends('layouts.customer')

@section('content')

<div style="
    min-height:100vh;
    padding:60px;
    background:
        linear-gradient(rgba(10,8,7,0.85), rgba(10,8,7,0.92)),
        url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f');
    background-size:cover;
    background-position:center;
    color:white;
">

    <h1 style="
        font-size:58px;
        font-family:'Poppins', sans-serif;
        color:#d8b67a;
        margin-bottom:45px;
    ">
        Salon Services
    </h1>

    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(340px,1fr));
        gap:28px;
    ">

        @foreach($services as $service)

        <div style="
            position:relative;
            overflow:hidden;
            border-radius:32px;
            min-height:420px;
            background:#1b1613;
            box-shadow:0 25px 50px rgba(0,0,0,0.35);
        ">

            <div style="
                height:220px;

                @if(strtolower($service->name) == 'haircut')
                    background:url('https://images.unsplash.com/photo-1621605815971-fbc98d665033');
                @elseif(strtolower($service->name) == 'hair coloring')
                    background:url('https://images.pexels.com/photos/3993449/pexels-photo-3993449.jpeg');
                @elseif(strtolower($service->name) == 'hair spa')
                    background:url('https://images.unsplash.com/photo-1515377905703-c4788e51af15');
                @else
                    background:url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f');
                @endif

                background-size:cover;
                background-position:center;
            ">
                <div style="
                    width:100%;
                    height:100%;
                    background:linear-gradient(rgba(0,0,0,0.15), rgba(0,0,0,0.55));
                "></div>
            </div>

            <div style="padding:30px;">

                <h2 style="
                    font-size:36px;
                    color:#d8b67a;
                    margin:0;
                    font-family:'Poppins', sans-serif;
                    font-weight:400;
                ">
                    {{ $service->name }}
                </h2>

                <p style="
                    color:#d0c7bc;
                    line-height:1.8;
                    margin-top:15px;
                    min-height:60px;
                ">
                    {{ $service->description }}
                </p>

                <div style="
                    margin-top:18px;
                    font-size:26px;
                    font-weight:bold;
                    color:white;
                ">
                    Rp {{ number_format($service->price) }}
                </div>

                <a href="{{ route('customer.booking', ['service_id' => $service->id]) }}" style="
                    display:inline-block;
                    margin-top:28px;
                    background:#d8b67a;
                    color:#1f1a17;
                    padding:14px 26px;
                    border-radius:16px;
                    font-weight:bold;
                    cursor:pointer;
                    font-size:15px;
                    text-decoration:none;
                ">
                    Book Service
                </a>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection