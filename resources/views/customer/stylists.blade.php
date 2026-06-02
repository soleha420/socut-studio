@extends('layouts.customer')

@section('content')

<style>
    .stylists-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 20px;
    }
    .stylists-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .stylist-card {
        background: #14110f;
        border-radius: 24px;
        padding: 40px 30px;
        text-align: center;
        border: 1px solid rgba(216, 182, 122, 0.12);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
    }
    .stylist-card:hover {
        transform: translateY(-6px);
        border-color: #d8b67a;
        box-shadow: 0 20px 45px rgba(216, 182, 122, 0.08);
    }
    .stylist-photo-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin-bottom: 24px;
    }
    .stylist-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(216, 182, 122, 0.3);
        transition: all 0.3s ease;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
    }
    .stylist-card:hover .stylist-photo {
        border-color: #d8b67a;
        box-shadow: 0 0 25px rgba(216, 182, 122, 0.25);
    }
    .stylist-initials {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #d8b67a, #b89358);
        color: #100d0c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 46px;
        font-weight: 800;
        border: 3px solid rgba(216, 182, 122, 0.3);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        transition: all 0.3s ease;
    }
    .stylist-card:hover .stylist-initials {
        border-color: #d8b67a;
        box-shadow: 0 0 25px rgba(216, 182, 122, 0.25);
    }
    .stylist-name {
        font-family: 'Poppins', sans-serif;
        font-size: 26px;
        color: #d8b67a;
        margin: 0 0 6px 0;
    }
    .stylist-specialty {
        color: #f8f7f6;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }
    .stylist-gender-pill {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        background: rgba(216, 182, 122, 0.08);
        color: #d8b67a;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid rgba(216, 182, 122, 0.15);
        margin-bottom: 20px;
    }
    .stylist-bio {
        color: #c4bbb0;
        font-size: 14px;
        line-height: 1.6;
        margin: 0;
        flex-grow: 1;
    }
</style>

<div class="stylists-container">
    <div style="border-bottom: 1px solid rgba(216, 182, 122, 0.15); padding-bottom: 20px; margin-bottom: 40px;">
        <p style="color:#d8b67a; letter-spacing:4px; font-size:12px; font-weight:bold; margin: 0 0 8px 0; text-transform: uppercase;">
            Expert Stylist Team
        </p>
        <h1 style="font-family: 'Poppins', sans-serif; font-size: 48px; font-weight: 400; margin: 0; color: white;">
            Penata Rambut Profesional
        </h1>
    </div>

    <div class="stylists-grid">
        @foreach($stylists as $stylist)
            <div class="stylist-card">
                <!-- Photo or Initials -->
                <div class="stylist-photo-wrapper">
                    @if($stylist->photo)
                        <img src="{{ asset('storage/' . $stylist->photo) }}" alt="{{ $stylist->name }}" class="stylist-photo">
                    @else
                        <div class="stylist-initials">
                            {{ strtoupper(substr($stylist->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <!-- Stylist Info -->
                <h2 class="stylist-name">{{ $stylist->name }}</h2>
                <div class="stylist-specialty">{{ $stylist->specialist }}</div>
                <div>
                    <span class="stylist-gender-pill">{{ $stylist->gender }}</span>
                </div>
                
                <!-- Description Biography -->
                <p class="stylist-bio">
                    {{ $stylist->description ?: 'Penata rambut berpengalaman yang berdedikasi tinggi dalam memberikan potongan, pewarnaan, dan perawatan rambut premium yang dipersonalisasi khusus untuk menonjolkan karakter terbaik Anda.' }}
                </p>
            </div>
        @endforeach
    </div>
</div>

@endsection