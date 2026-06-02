@extends('layouts.admin')

@section('content')

<style>
    .stylist-create-card {
        max-width: 850px;
        margin: 24px auto;
        padding: 55px 45px;
        background: #100d0b;
        border: 1px solid #3b2d22;
        border-radius: 28px;
        color: #fff;
    }

    .stylist-create-card h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 48px;
        color: #f5c66b;
        margin-bottom: 18px;
    }

    .stylist-create-card p {
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

    select.form-control {
        appearance: none;
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

    .alert-error {
        background: #2a1412;
        color: #ffb4a5;
        border: 1px solid #5f2c26;
        padding: 16px 18px;
        border-radius: 14px;
        margin-bottom: 28px;
        font-weight: 600;
    }

    .btn-save {
        margin-top: 10px;
        padding: 15px 28px;
        background: #f5c66b;
        border: none;
        border-radius: 12px;
        color: #100d0b;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-save:hover {
        background: #e6b85f;
    }
</style>

<div class="stylist-create-card">

    <h1>Add Stylist Salon</h1>

    <p>s
        Create new stylist data and manage salon specialist information.
    </p>

    @if ($errors->any())
        <div class="alert-error">
            Please complete the stylist data firstS.
        </div>
    @endif

    <form action="{{ route('admin.stylists.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="form-group">

            <label>Name</label>

            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control @error('name') input-error @enderror"
                   placeholder="Enter stylist name">

            @error('name')
                <small class="error-text">
                    {{ $message }}
                </small>
            @enderror

        </div>

        <div class="form-group">

            <label>Specialist</label>

            <input type="text"
                   name="specialist"
                   value="{{ old('specialist') }}"
                   class="form-control @error('specialist') input-error @enderror"
                   placeholder="Enter specialist">

            @error('specialist')
                <small class="error-text">
                    {{ $message }}
                </small>
            @enderror

        </div>

        <div class="form-group">

            <label>Gender</label>

            <select name="gender"
                    class="form-control @error('gender') input-error @enderror">

                <option value="">
                    Choose Gender
                </option>

                <option value="Male"
                    {{ old('gender') == 'Male' ? 'selected' : '' }}>
                    Male
                </option>

                <option value="Female"
                    {{ old('gender') == 'Female' ? 'selected' : '' }}>
                    Female
                </option>

            </select>

            @error('gender')
                <small class="error-text">
                    {{ $message }}
                </small>
            @enderror

        </div>

        <div class="form-group">
            <label>Description</label>

            <textarea name="description"
                      class="form-control @error('description') input-error @enderror"
                      style="min-height: 120px; resize: vertical;"
                      placeholder="Enter stylist biography">{{ old('description') }}</textarea>

            @error('description')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Photo</label>

            <input type="file"
                   name="photo"
                   class="form-control @error('photo') input-error @enderror"
                   accept="image/*"
                   onchange="previewPhoto(event)"
                   style="cursor: pointer; padding: 12px 16px !important;">

            @error('photo')
                <small class="error-text">{{ $message }}</small>
            @enderror

            <!-- Live Preview -->
            <div id="photo-preview-wrapper" style="margin-top: 15px; display: none;">
                <p style="margin-bottom: 8px; font-size: 13px; color: #8f857a;">Pratinjau Foto:</p>
                <img id="photo-preview" src="#" alt="Pratinjau" style="max-height: 180px; border-radius: 12px; border: 1px solid rgba(216,182,122,0.3); object-fit: cover;">
            </div>
        </div>

        <button type="submit" class="btn-save">
            Save Stylist
        </button>

    </form>

</div>

<script>
    function previewPhoto(event) {
        const input = event.target;
        const wrapper = document.getElementById('photo-preview-wrapper');
        const preview = document.getElementById('photo-preview');
        
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