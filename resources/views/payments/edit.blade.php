@extends('layouts.app')

@section('content')
<style>
    .payment-container {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 30px;
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    @media (max-width: 900px) {
        .payment-container {
            grid-template-columns: 1fr;
            margin: 20px auto;
        }
    }
    .panel-card {
        background: #1a1715;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(216, 182, 122, 0.15);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        height: fit-content;
    }
    .payment-title {
        color: #d8b67a;
        font-family: 'Poppins', sans-serif;
        font-size: 28px;
        margin-top: 0;
        margin-bottom: 24px;
        border-bottom: 1px solid rgba(216, 182, 122, 0.15);
        padding-bottom: 12px;
    }
    .detail-item {
        margin-bottom: 16px;
        display: flex;
        justify-content: space-between;
        border-bottom: 1px dashed rgba(216, 182, 122, 0.1);
        padding-bottom: 10px;
    }
    .detail-label {
        color: #999;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .detail-value {
        color: white;
        font-weight: bold;
        font-size: 15px;
    }
    .method-selector {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 24px;
    }
    @media (max-width: 480px) {
        .method-selector {
            grid-template-columns: 1fr;
        }
    }
    .method-card {
        background: #231e1a;
        border: 2px solid rgba(216, 182, 122, 0.15);
        border-radius: 14px;
        padding: 20px 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    .method-card:hover {
        border-color: #d8b67a;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(216, 182, 122, 0.08);
    }
    .method-card.active {
        border-color: #d8b67a;
        background: rgba(216, 182, 122, 0.08);
        box-shadow: 0 0 20px rgba(216, 182, 122, 0.15);
    }
    .method-card svg {
        width: 36px;
        height: 36px;
        fill: #8c8279;
        transition: all 0.3s;
    }
    .method-card.active svg, .method-card:hover svg {
        fill: #d8b67a;
        transform: scale(1.05);
    }
    .method-name {
        color: white;
        font-weight: bold;
        font-size: 14px;
        margin: 0;
    }
    .instruction-box {
        background: rgba(35, 30, 26, 0.6);
        border-radius: 14px;
        padding: 24px;
        border: 1px dashed rgba(216, 182, 122, 0.3);
        margin-bottom: 24px;
        display: none;
    }
    .instruction-box.active {
        display: block;
        animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .bank-account-card {
        background: #1a1715;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 12px;
        border: 1px solid rgba(216, 182, 122, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .copy-btn {
        background: rgba(216, 182, 122, 0.1);
        color: #d8b67a;
        border: 1px solid rgba(216, 182, 122, 0.3);
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        transition: all 0.2s;
    }
    .copy-btn:hover {
        background: #d8b67a;
        color: #1f1a17;
    }
    .input-group {
        margin-bottom: 24px;
    }
    .input-label {
        display: block;
        color: #d8b67a;
        font-weight: bold;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .input-control {
        width: 100%;
        padding: 14px;
        background: #231e1a;
        border: 1px solid rgba(216, 182, 122, 0.25);
        border-radius: 8px;
        color: white;
        box-sizing: border-box;
        font-size: 15px;
        transition: all 0.3s;
    }
    .input-control:focus {
        border-color: #d8b67a;
        outline: none;
        box-shadow: 0 0 8px rgba(216, 182, 122, 0.2);
    }
    .file-upload-zone {
        border: 2px dashed rgba(216, 182, 122, 0.3);
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        background: #231e1a;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }
    .file-upload-zone:hover {
        border-color: #d8b67a;
        background: rgba(216, 182, 122, 0.03);
    }
    .preview-container {
        margin-top: 15px;
        text-align: center;
    }
    .preview-image {
        max-width: 100%;
        max-height: 250px;
        border-radius: 8px;
        border: 1px solid rgba(216, 182, 122, 0.3);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
    .action-btn {
        padding: 14px 28px;
        border-radius: 10px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .btn-primary {
        background: #d8b67a;
        color: #1f1a17;
        border: none;
    }
    .btn-primary:hover {
        background: #e4c894;
        box-shadow: 0 5px 15px rgba(216, 182, 122, 0.3);
    }
    .btn-secondary {
        background: rgba(216, 182, 122, 0.1);
        color: #d8b67a;
        border: 1px solid rgba(216, 182, 122, 0.3);
    }
    .btn-secondary:hover {
        background: rgba(216, 182, 122, 0.2);
    }
</style>

<div class="payment-container">
    {{-- LEFT COLUMN: APPOINTMENT DETAILS --}}
    <div class="panel-card">
        <h2 class="payment-title">Detail Janji Temu</h2>
        
        <div style="text-align: center; margin-bottom: 25px;">
            <div style="background: rgba(216, 182, 122, 0.1); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d8b67a" stroke-width="2">
                    <path d="M19 4H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
            </div>
            <h3 style="color: white; margin: 0; font-size: 20px;">{{ $payment->appointment->service->name }}</h3>
            <p style="color: #d8b67a; font-weight: bold; font-size: 24px; margin: 8px 0 0 0;">
                Rp {{ number_format($payment->appointment->service->price, 0, ',', '.') }}
            </p>
        </div>

        <div class="detail-item">
            <span class="detail-label">ID Pembayaran</span>
            <span class="detail-value">#{{ $payment->id }}</span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Stylist</span>
            <span class="detail-value">{{ $payment->appointment->stylist->name }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Tanggal</span>
            <span class="detail-value">{{ $payment->appointment->appointment_date }}</span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Jam</span>
            <span class="detail-value">{{ $payment->appointment->appointment_time }}</span>
        </div>

        <div class="detail-item" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
            <span class="detail-label">Catatan Booking</span>
            <span class="detail-value" style="font-weight: normal; color: #ccc; max-width: 60%; text-align: right;">
                {{ $payment->appointment->notes ?: '-' }}
            </span>
        </div>
    </div>

    {{-- RIGHT COLUMN: EDIT PAYMENT FORM --}}
    <div class="panel-card">
        <h2 class="payment-title">Edit Pembayaran</h2>
        
        @if ($errors->any())
            <div style="background: rgba(244, 67, 54, 0.1); border: 1px solid #f44336; border-radius: 8px; padding: 15px; margin-bottom: 20px; color: #f44336; font-size: 14px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('payments.update', $payment->id) }}" method="POST" enctype="multipart/form-data" id="payment_form">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="payment_method" id="payment_method_input" value="{{ old('payment_method', $payment->payment_method) }}">

            {{-- 1. CHOOSE PAYMENT METHOD --}}
            <div class="input-group">
                <label class="input-label">Metode Pembayaran *</label>
                <div class="method-selector">
                    {{-- Transfer Bank --}}
                    <div class="method-card {{ old('payment_method', $payment->payment_method) === 'transfer' ? 'active' : '' }}" data-method="transfer">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 10h3v7H4zm6.5 0h3v7h-3zM2 19h20v3H2zm15-9h3v7h-3zm-5-6L2 9h20z"/>
                        </svg>
                        <p class="method-name">Transfer Bank</p>
                        <span class="method-desc">BCA, Mandiri</span>
                    </div>

                    {{-- QRIS --}}
                    <div class="method-card {{ old('payment_method', $payment->payment_method) === 'qris' ? 'active' : '' }}" data-method="qris">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 4h6v6H4V4zm2 2v2h2V6H6zm8-2h6v6h-6V4zm2 2v2h2V6h-2zM4 14h6v6H4v-6zm2 2v2h2v-2H6zm10 0h2v2h-2v-2zm2-2h2v2h-2v-2zm-2 4h4v2h-4v-2zm2 2h2v2h-2v-2zm-4-6h2v2h-2v-2zm2 2h2v2h-2v-2zm-2 2h2v2h-2v-2z"/>
                        </svg>
                        <p class="method-name">QRIS</p>
                        <span class="method-desc">Gopay, OVO, Dana</span>
                    </div>

                    {{-- Credit Card --}}
                    <div class="method-card {{ old('payment_method', $payment->payment_method) === 'card' ? 'active' : '' }}" data-method="card">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                        </svg>
                        <p class="method-name">Kartu Kredit</p>
                        <span class="method-desc">Visa, Mastercard</span>
                    </div>
                </div>
            </div>

            {{-- 2. DYNAMIC PAYMENT INSTRUCTION PANELS --}}
            
            {{-- Instruction Bank Transfer --}}
            <div id="instruction_transfer" class="instruction-box {{ old('payment_method', $payment->payment_method) === 'transfer' ? 'active' : '' }}">
                <h4 style="color: #d8b67a; margin-top: 0; margin-bottom: 12px; font-size: 16px;">Rekening Pembayaran:</h4>
                
                <div class="bank-account-card">
                    <div>
                        <span style="background: #0056b3; color: white; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; margin-right: 6px;">BCA</span>
                        <strong style="color: white; font-size: 14px;">862-581-2290</strong>
                        <div style="font-size: 12px; color: #999; margin-top: 2px;">a/n So Cut Studio</div>
                    </div>
                    <button type="button" class="copy-btn" onclick="copyText('8625812290', this)">Salin</button>
                </div>

                <div class="bank-account-card">
                    <div>
                        <span style="background: #ffc107; color: #1f1a17; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; margin-right: 6px;">MANDIRI</span>
                        <strong style="color: white; font-size: 14px;">132-00-9876543-2</strong>
                        <div style="font-size: 12px; color: #999; margin-top: 2px;">a/n So Cut Studio</div>
                    </div>
                    <button type="button" class="copy-btn" onclick="copyText('1320098765432', this)">Salin</button>
                </div>

                <div style="margin-top: 20px;">
                    <label class="input-label" style="font-size: 13px;">Rekening Pengirim (Bank & Atas Nama) *</label>
                    <input type="text" name="bank_account" id="bank_account_input" value="{{ old('bank_account', $payment->bank_account) }}" placeholder="Contoh: BCA - Ahmad Fauzi" class="input-control">
                </div>
            </div>

            {{-- Instruction QRIS --}}
            <div id="instruction_qris" class="instruction-box {{ old('payment_method', $payment->payment_method) === 'qris' ? 'active' : '' }}">
                <h4 style="color: #d8b67a; margin-top: 0; margin-bottom: 8px; font-size: 16px; text-align: center;">Scan Kode QRIS</h4>
                <p style="color: #ccc; font-size: 12px; text-align: center; margin-bottom: 16px; line-height: 1.5;">
                    Scan QRIS di bawah ini dengan aplikasi M-Banking atau Dompet Digital (Gopay, OVO, Dana, LinkAja, dll).
                </p>

                {{-- SVG QRIS Code --}}
                <svg width="180" height="180" viewBox="0 0 100 100" style="background:white; padding:15px; border-radius:12px; margin: 10px auto; display:block; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                    <!-- QRIS Header Banner -->
                    <rect x="0" y="0" width="100" height="15" rx="3" fill="#003554"/>
                    <text x="50" y="10" fill="white" font-size="7" font-weight="bold" font-family="sans-serif" text-anchor="middle">QRIS</text>
                    
                    <!-- Top-Left Detection Pattern -->
                    <rect x="10" y="25" width="20" height="20" fill="black"/>
                    <rect x="13" y="28" width="14" height="14" fill="white"/>
                    <rect x="15" y="30" width="10" height="10" fill="black"/>
                    
                    <!-- Top-Right Detection Pattern -->
                    <rect x="70" y="25" width="20" height="20" fill="black"/>
                    <rect x="73" y="28" width="14" height="14" fill="white"/>
                    <rect x="75" y="30" width="10" height="10" fill="black"/>
                    
                    <!-- Bottom-Left Detection Pattern -->
                    <rect x="10" y="70" width="20" height="20" fill="black"/>
                    <rect x="13" y="73" width="14" height="14" fill="white"/>
                    <rect x="15" y="75" width="10" height="10" fill="black"/>
                    
                    <!-- Center Logo -->
                    <rect x="42" y="52" width="16" height="16" rx="2" fill="#003554"/>
                    <text x="50" y="62" fill="white" font-size="6" font-weight="bold" font-family="sans-serif" text-anchor="middle">SoCut</text>
                    
                    <!-- Mock QR Squares -->
                    <rect x="35" y="25" width="5" height="5" fill="black"/>
                    <rect x="45" y="25" width="10" height="5" fill="black"/>
                    <rect x="60" y="25" width="5" height="10" fill="black"/>
                    <rect x="35" y="35" width="15" height="5" fill="black"/>
                    <rect x="55" y="35" width="5" height="5" fill="black"/>
                    <rect x="35" y="45" width="5" height="10" fill="black"/>
                    <rect x="45" y="45" width="10" height="5" fill="black"/>
                    <rect x="60" y="45" width="15" height="5" fill="black"/>
                    <rect x="35" y="70" width="5" height="15" fill="black"/>
                    <rect x="45" y="70" width="10" height="5" fill="black"/>
                    <rect x="60" y="70" width="5" height="10" fill="black"/>
                    <rect x="70" y="70" width="15" height="5" fill="black"/>
                    <rect x="45" y="80" width="15" height="10" fill="black"/>
                    <rect x="70" y="80" width="5" height="10" fill="black"/>
                    <rect x="80" y="80" width="10" height="5" fill="black"/>
                </svg>

                <p style="color: #d8b67a; font-weight: bold; text-align: center; font-size: 13px; margin: 12px 0 0 0;">
                    SO CUT HAIR STUDIO
                </p>
            </div>

            {{-- Instruction Card --}}
            <div id="instruction_card" class="instruction-box {{ old('payment_method', $payment->payment_method) === 'card' ? 'active' : '' }}">
                <h4 style="color: #d8b67a; margin-top: 0; margin-bottom: 8px; font-size: 16px;">Kartu Kredit / Debit:</h4>
                <p style="color: #ccc; font-size: 13px; line-height: 1.6; margin: 0;">
                    Kami mendukung kartu Visa dan Mastercard. Pembayaran dapat diselesaikan langsung di kasir studio salon kami sebelum atau setelah pengerjaan rambut menggunakan mesin EDC kami. Silakan upload screenshot halaman booking ini sebagai bukti konfirmasi.
                </p>
            </div>

            {{-- 3. PAYMENT AMOUNT --}}
            <div class="input-group">
                <label class="input-label" for="amount_input">Jumlah Pembayaran (Rp) *</label>
                <input type="number" name="amount" id="amount_input" value="{{ old('amount', $payment->amount) }}" step="0.01" required class="input-control">
            </div>

            {{-- 4. PROOF OF PAYMENT UPLOAD WITH PREVIEW --}}
            <div class="input-group">
                <label class="input-label">Bukti Pembayaran (Gambar)</label>
                
                {{-- Live Preview Container --}}
                <div id="preview_wrapper" class="preview-container" style="margin-bottom: 15px;">
                    @if($payment->proof_image)
                        <p style="color: #999; font-size: 13px; margin: 0 0 10px 0;">Bukti Pembayaran Saat Ini:</p>
                        <img id="image_preview" src="{{ asset('storage/payments/' . $payment->proof_image) }}" alt="Pratinjau Bukti" class="preview-image">
                    @else
                        <p style="color: #d8b67a; font-size: 13px; font-weight: bold; margin: 0 0 10px 0; display:none;" id="preview_title">Pratinjau Bukti Transfer Baru:</p>
                        <img id="image_preview" src="#" alt="Pratinjau Bukti" class="preview-image" style="display: none;">
                    @endif
                </div>

                <div class="file-upload-zone" onclick="document.getElementById('proof_image_input').click()">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#d8b67a" stroke-width="2" style="margin-bottom: 10px; display: inline-block;">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <p style="color: white; font-weight: bold; margin: 0 0 6px 0; font-size: 14px;">Klik untuk Ganti Gambar</p>
                    <p style="color: #999; margin: 0; font-size: 12px;">Biarkan kosong jika tidak ingin mengubah bukti saat ini</p>
                    
                    <input type="file" name="proof_image" id="proof_image_input" accept="image/*" style="display: none;">
                </div>
            </div>

            {{-- 5. NOTES --}}
            <div class="input-group">
                <label class="input-label" for="notes_input">Catatan Pembayaran (Opsional)</label>
                <textarea name="notes" id="notes_input" rows="3" placeholder="Tambahkan catatan jika diperlukan..." class="input-control" style="font-family: 'Poppins', sans-serif; resize: vertical;">{{ old('notes', $payment->notes) }}</textarea>
            </div>

            {{-- 6. FORM BUTTONS --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 30px;">
                <button type="submit" class="action-btn btn-primary">
                    Simpan Perubahan
                </button>
                <a href="{{ route('payments.show', $payment->id) }}" class="action-btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Handle Interactive Payment Cards Selector
    document.querySelectorAll('.method-card').forEach(card => {
        card.addEventListener('click', function() {
            // Remove active classes
            document.querySelectorAll('.method-card').forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked card
            this.classList.add('active');
            
            // Set hidden input value
            const method = this.getAttribute('data-method');
            document.getElementById('payment_method_input').value = method;
            
            // Toggle Instruction Panels
            document.querySelectorAll('.instruction-box').forEach(box => {
                box.classList.remove('active');
            });
            
            const targetBox = document.getElementById('instruction_' + method);
            if (targetBox) {
                targetBox.classList.add('active');
            }
            
            // Adjust validation requirements
            const bankAccountInput = document.getElementById('bank_account_input');
            if (method === 'transfer') {
                bankAccountInput.setAttribute('required', 'required');
            } else {
                bankAccountInput.removeAttribute('required');
            }
        });
    });

    // Copy to clipboard helper
    function copyText(text, btnElement) {
        navigator.clipboard.writeText(text).then(() => {
            const originalText = btnElement.innerText;
            btnElement.innerText = 'Tersalin!';
            btnElement.style.background = '#4caf50';
            btnElement.style.color = 'white';
            btnElement.style.borderColor = '#4caf50';
            
            setTimeout(() => {
                btnElement.innerText = originalText;
                btnElement.style.background = 'rgba(216, 182, 122, 0.1)';
                btnElement.style.color = '#d8b67a';
                btnElement.style.borderColor = 'rgba(216, 182, 122, 0.3)';
            }, 2000);
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    }

    // Set initial validation
    window.addEventListener('DOMContentLoaded', () => {
        const initialMethod = document.getElementById('payment_method_input').value;
        const bankAccountInput = document.getElementById('bank_account_input');
        if (initialMethod === 'transfer') {
            bankAccountInput.setAttribute('required', 'required');
        }
    });

    // Image upload preview handler
    document.getElementById('proof_image_input').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('image_preview');
                const previewWrapper = document.getElementById('preview_wrapper');
                const previewTitle = document.getElementById('preview_title');
                
                previewImg.src = e.target.result;
                previewImg.style.display = 'inline-block';
                if (previewTitle) previewTitle.style.display = 'block';
                previewWrapper.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

