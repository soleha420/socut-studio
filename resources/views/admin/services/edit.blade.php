@extends('layouts.admin')

@section('content')

<style>
    .service-edit-card {
        max-width: 850px;
        margin: 24px auto;
        padding: 55px 45px;
        background: #100d0b;
        border: 1px solid #3b2d22;
        border-radius: 28px;
        color: #fff;
    }

    .service-edit-card h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 48px;
        color: #f5c66b;
        margin-bottom: 18px;
    }

    .service-edit-card p {
        margin-bottom: 42px;
        color: #f3f3f3;
    }

    .form-group {
        margin-bottom: 28px;
    }

    .form-group label {
        display: block;
        margin-bottom: 12px;
        color: #f5c66b;
        font-weight: bold;
    }

    .form-control {
        width: 100%;
        padding: 18px 16px;
        background: #241b17;
        border: 1px solid #4a382c;
        border-radius: 14px;
        color: #fff;
        font-size: 15px;
        outline: none;
    }

    .form-control:focus {
        border-color: #f5c66b;
    }

    .input-error {
        border-color: #ff6b6b !important;
    }

    .error-text {
        display: block;
        color: #ff8d8d;
        font-size: 14px;
        margin-top: 8px;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .alert-error {
        background: #2a1412;
        color: #ffb4a5;
        border: 1px solid #5f2c26;
        padding: 16px 18px;
        border-radius: 14px;
        margin-bottom: 28px;
        font-weight: 600;
    }

    .action-form {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .btn-update {
        padding: 15px 28px;
        background: #f5c66b;
        border: none;
        border-radius: 12px;
        color: #100d0b;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-update:hover {
        background: #e6b85f;
    }

    .btn-back {
        padding: 15px 24px;
        background: #262321;
        color: #ffd28a;
        border: 1px solid #49423c;
        border-radius: 12px;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-back:hover {
        background: #332f2b;
    }
</style>

<div class="service-edit-card">
    <h1>Edit Service Salon</h1>
    <p>Update salon service information and pricing details.</p>

    @if ($errors->any())
        <div class="alert-error">
            Mohon lengkapi data service terlebih dahulu.
        </div>
    @endif

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Service Name</label>

            <input type="text"
                   name="name"
                   class="form-control @error('name') input-error @enderror"
                   value="{{ old('name', $service->name) }}"
                   placeholder="Enter service name">

            @error('name')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Description</label>

            <textarea name="description"
                      class="form-control @error('description') input-error @enderror"
                      placeholder="Enter service description">{{ old('description', $service->description) }}</textarea>

            @error('description')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Price</label>

            <input type="number"
                   name="price"
                   class="form-control @error('price') input-error @enderror"
                   value="{{ old('price', $service->price) }}"
                   placeholder="Enter price">

            @error('price')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Duration</label>

            <input type="number"
                   name="duration"
                   class="form-control @error('duration') input-error @enderror"
                   value="{{ old('duration', $service->duration) }}"
                   placeholder="Enter duration in minutes">

            @error('duration')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Service Image</label>

            <!-- Old image preview -->
            @if($service->image)
                <div style="margin-bottom: 15px;">
                    <p style="margin-bottom: 8px; font-size: 13px; color: #8f857a;">Gambar Saat Ini:</p>
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" style="max-height: 150px; border-radius: 12px; border: 1px solid rgba(216,182,122,0.2); object-fit: cover;">
                </div>
            @endif

            <input type="file"
                   name="image"
                   class="form-control @error('image') input-error @enderror"
                   accept="image/*"
                   onchange="previewImage(event)"
                   style="cursor: pointer; padding: 12px 16px !important;">

            @error('image')
                <small class="error-text">{{ $message }}</small>
            @enderror

            <!-- New Image Live Preview -->
            <div id="image-preview-wrapper" style="margin-top: 15px; display: none;">
                <p style="margin-bottom: 8px; font-size: 13px; color: #8f857a;">Pratinjau Gambar Baru:</p>
                <img id="image-preview" src="#" alt="Pratinjau Baru" style="max-height: 150px; border-radius: 12px; border: 1px solid rgba(216,182,122,0.3); object-fit: cover;">
            </div>
        </div>

        <div class="action-form">
            <button type="submit" class="btn-update">
                Update Service
            </button>

            <a href="{{ route('admin.services.index') }}" class="btn-back">
                Back
            </a>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const wrapper = document.getElementById('image-preview-wrapper');
        const preview = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                wrapper.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            wrapper.style.display = 'none';
        }
    }
</script>

@endsection