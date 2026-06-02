@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.customer')

@section('content')

<style>
    .profile-page {
        min-height: 100vh;
        background:
            linear-gradient(rgba(10,8,7,0.88), rgba(10,8,7,0.92)),
            url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f');
        background-size: cover;
        background-position: center;
        padding: 60px 40px;
        color: white;
        font-family: 'Poppins', sans-serif;
    }
    .profile-inner {
        max-width: 820px;
        margin: auto;
    }

    /* ─── Photo Card ─── */
    .photo-card {
        background: rgba(18,15,13,0.85);
        border-radius: 28px;
        padding: 40px;
        border: 1px solid rgba(216,182,122,0.12);
        backdrop-filter: blur(18px);
        margin-bottom: 28px;
    }
    .photo-section {
        display: flex;
        align-items: center;
        gap: 36px;
        flex-wrap: wrap;
    }

    /* Avatar circle */
    .avatar-ring {
        position: relative;
        flex-shrink: 0;
    }
    .avatar-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #d8b67a;
        box-shadow: 0 0 0 4px rgba(216,182,122,0.15);
        display: block;
        transition: all 0.3s;
    }
    .avatar-initials {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #d8b67a, #a8845a);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 46px;
        font-weight: 700;
        color: #1a1208;
        border: 3px solid #d8b67a;
        box-shadow: 0 0 0 4px rgba(216,182,122,0.15);
        line-height: 1;
    }
    .avatar-ring:hover .avatar-overlay {
        opacity: 1;
    }
    .avatar-overlay {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.25s;
        cursor: pointer;
    }
    .avatar-overlay svg { color: white; }

    /* Upload zone */
    .upload-zone {
        flex-grow: 1;
    }
    .upload-label {
        display: block;
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 8px;
    }
    .dropzone {
        border: 2px dashed rgba(216,182,122,0.3);
        border-radius: 16px;
        padding: 24px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s;
        background: rgba(216,182,122,0.03);
        position: relative;
    }
    .dropzone:hover, .dropzone.dragover {
        border-color: #d8b67a;
        background: rgba(216,182,122,0.07);
    }
    .dropzone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .dropzone-icon { color: #d8b67a; margin-bottom: 8px; }
    .dropzone-text  { color: #aaa; font-size: 14px; }
    .dropzone-text strong { color: #d8b67a; }
    .dropzone-hint  { color: #555; font-size: 11px; margin-top: 4px; }

    /* Preview strip */
    #preview-strip {
        display: none;
        margin-top: 16px;
        align-items: center;
        gap: 14px;
        background: rgba(216,182,122,0.05);
        border: 1px solid rgba(216,182,122,0.2);
        border-radius: 12px;
        padding: 12px 16px;
    }
    #preview-strip.visible { display: flex; }
    #preview-strip img {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #d8b67a;
    }
    #preview-info { flex-grow: 1; }
    #preview-name { font-size: 14px; font-weight: 600; color: #d8b67a; }
    #preview-size { font-size: 12px; color: #777; margin-top: 2px; }

    .btn-upload {
        background: linear-gradient(135deg, #d8b67a, #b8945e);
        color: #120e0c;
        border: none;
        padding: 12px 26px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.25s;
        margin-top: 16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-upload:hover {
        background: linear-gradient(135deg, #eacc95, #d8b67a);
        box-shadow: 0 6px 18px rgba(216,182,122,0.3);
        transform: translateY(-1px);
    }
    .btn-remove {
        background: rgba(244,67,54,0.1);
        border: 1px solid rgba(244,67,54,0.25);
        color: #f44336;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.25s;
        margin-top: 16px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }
    .btn-remove:hover { background: rgba(244,67,54,0.2); }

    /* ─── Info Card ─── */
    .info-card {
        background: rgba(18,15,13,0.85);
        border-radius: 28px;
        padding: 40px;
        border: 1px solid rgba(216,182,122,0.12);
        backdrop-filter: blur(18px);
        margin-bottom: 28px;
    }
    .card-title {
        color: #d8b67a;
        font-size: 22px;
        font-weight: 600;
        margin: 0 0 6px;
    }
    .card-subtitle { color: #666; font-size: 13px; margin: 0 0 28px; }

    .info-field { margin-bottom: 20px; }
    .info-field label {
        display: block;
        color: #d8b67a;
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .info-field .val {
        background: rgba(216,182,122,0.06);
        border: 1px solid rgba(216,182,122,0.12);
        padding: 14px 18px;
        border-radius: 12px;
        color: #ddd;
        font-size: 15px;
    }

    /* Alert */
    .alert {
        padding: 14px 20px;
        border-radius: 14px;
        margin-bottom: 24px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }
    .alert-success { background: rgba(76,175,80,0.12); border: 1px solid rgba(76,175,80,0.3); color: #4caf50; }
    .alert-gold    { background: rgba(216,182,122,0.12); border: 1px solid rgba(216,182,122,0.3); color: #d8b67a; }
    .alert-error   { background: rgba(244,67,54,0.12); border: 1px solid rgba(244,67,54,0.3); color: #f44336; }

    /* Logout */
    .btn-logout {
        background: #d8b67a;
        color: #1f1a17;
        border: none;
        padding: 14px 28px;
        border-radius: 14px;
        font-weight: 700;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.25s;
    }
    .btn-logout:hover { background: #eacc95; box-shadow: 0 6px 18px rgba(216,182,122,0.25); }

    @media (max-width: 600px) {
        .profile-page { padding: 30px 20px; }
        .photo-card, .info-card { padding: 24px; }
        .photo-section { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="profile-page">
    <div class="profile-inner">

        <p style="color:#d8b67a; letter-spacing:4px; font-size:12px; font-weight:700; text-transform:uppercase; margin:0 0 10px;">
            {{ auth()->user()->role === 'admin' ? 'Admin Panel' : 'Customer Profile' }}
        </p>
        <h1 style="font-size:50px; font-family:'Poppins',sans-serif; font-weight:400; margin:0 0 40px; color:white;">
            Account Settings
        </h1>

        {{-- ── Alerts ── --}}
        @if(session('status') === 'photo-updated')
            <div class="alert alert-success">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Foto profil berhasil diperbarui!
            </div>
        @elseif(session('status') === 'photo-removed')
            <div class="alert alert-gold">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Foto profil berhasil dihapus.
            </div>
        @elseif(session('status') === 'profile-updated')
            <div class="alert alert-success">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Profil berhasil diperbarui.
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ── Photo Upload Card ── --}}
        <div class="photo-card">
            <h2 class="card-title">Foto Profil</h2>
            <p class="card-subtitle">Upload foto untuk tampil di avatar akun Anda. Format: JPEG, PNG, WEBP. Maks 2MB.</p>

            <div class="photo-section">
                {{-- Current avatar --}}
                <div class="avatar-ring" onclick="document.getElementById('photo-input').click()" title="Klik untuk ganti foto">
                    @if(auth()->user()->profile_photo)
                        <img id="current-avatar" class="avatar-img"
                             src="{{ asset('storage/profile_photos/' . auth()->user()->profile_photo) }}"
                             alt="Foto Profil">
                    @else
                        <div class="avatar-initials" id="current-avatar-init">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="avatar-overlay">
                        <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Upload form --}}
                <div class="upload-zone">
                    <form action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data" id="photo-form">
                        @csrf
                        <label class="upload-label">Pilih Foto Baru</label>
                        <div class="dropzone" id="dropzone" onclick="document.getElementById('photo-input').click()">
                            <input type="file" name="profile_photo" id="photo-input" accept="image/*" onchange="previewPhoto(this)">
                            <div class="dropzone-icon">
                                <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="dropzone-text"><strong>Klik di sini</strong> atau seret & lepas foto</div>
                            <div class="dropzone-hint">JPEG, PNG, GIF, WEBP • Maks. 2MB</div>
                        </div>

                        {{-- Preview strip --}}
                        <div id="preview-strip">
                            <img id="preview-img" src="" alt="Preview">
                            <div id="preview-info">
                                <div id="preview-name">—</div>
                                <div id="preview-size">—</div>
                            </div>
                        </div>

                        <button type="submit" class="btn-upload" id="upload-btn" style="display:none;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Simpan Foto Profil
                        </button>
                    </form>

                    {{-- Remove photo --}}
                    @if(auth()->user()->profile_photo)
                        <form action="{{ route('profile.photo.remove') }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus foto profil?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus Foto
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Info Card ── --}}
        <div class="info-card">
            <h2 class="card-title">Informasi Akun</h2>
            <p class="card-subtitle">Data akun Anda yang terdaftar di sistem.</p>

            <div class="info-field">
                <label>Nama Lengkap</label>
                <div class="val">{{ auth()->user()->name }}</div>
            </div>
            <div class="info-field">
                <label>Email Address</label>
                <div class="val">{{ auth()->user()->email }}</div>
            </div>
            <div class="info-field">
                <label>Role Akun</label>
                <div class="val" style="text-transform:capitalize;">{{ auth()->user()->role }}</div>
            </div>
            <div class="info-field" style="margin-bottom:0;">
                <label>Bergabung Sejak</label>
                <div class="val">{{ auth()->user()->created_at->format('d F Y') }}</div>
            </div>
        </div>

        {{-- ── Logout Card ── --}}
        <div class="info-card">
            <h2 class="card-title">Logout</h2>
            <p class="card-subtitle">Keluar dari sesi akun Anda dengan aman.</p>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

    </div>
</div>

<script>
    function previewPhoto(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        const maxSize = 2 * 1024 * 1024;

        if (file.size > maxSize) {
            alert('Ukuran foto terlalu besar! Maksimal 2MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            // Update live avatar preview
            const avatarImg  = document.getElementById('current-avatar');
            const avatarInit = document.getElementById('current-avatar-init');

            if (avatarImg) {
                avatarImg.src = e.target.result;
            } else if (avatarInit) {
                // Replace initials div with actual img element
                const img = document.createElement('img');
                img.id        = 'current-avatar';
                img.className = 'avatar-img';
                img.src       = e.target.result;
                img.alt       = 'Preview';
                avatarInit.replaceWith(img);
            }

            // Show preview strip
            document.getElementById('preview-img').src  = e.target.result;
            document.getElementById('preview-name').textContent = file.name;
            document.getElementById('preview-size').textContent =
                (file.size / 1024 < 1024)
                    ? (file.size / 1024).toFixed(1) + ' KB'
                    : (file.size / 1024 / 1024).toFixed(2) + ' MB';

            document.getElementById('preview-strip').classList.add('visible');
            document.getElementById('upload-btn').style.display = 'inline-flex';
        };
        reader.readAsDataURL(file);
    }

    // Drag & Drop
    const dz = document.getElementById('dropzone');
    dz.addEventListener('dragover',  e => { e.preventDefault(); dz.classList.add('dragover'); });
    dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
    dz.addEventListener('drop', e => {
        e.preventDefault();
        dz.classList.remove('dragover');
        const input = document.getElementById('photo-input');
        input.files = e.dataTransfer.files;
        previewPhoto(input);
    });
</script>

@endsection