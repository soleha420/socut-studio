@extends('layouts.admin')

@section('content')

<style>
    .appt-table-wrap {
        background: rgba(18,15,13,0.92);
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid rgba(216,182,122,0.2);
    }
    .appt-table {
        width: 100%;
        border-collapse: collapse;
        color: white;
    }
    .appt-table thead {
        background: rgba(216,182,122,0.08);
    }
    .appt-table th {
        padding: 16px 18px;
        text-align: left;
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #d8b67a;
        font-weight: 600;
        white-space: nowrap;
    }
    .appt-table tbody tr.main-row {
        border-top: 1px solid rgba(255,255,255,0.06);
        transition: background 0.2s;
    }
    .appt-table tbody tr.main-row:hover {
        background: rgba(216,182,122,0.04);
    }
    .appt-table tbody tr.main-row.row-pending {
        border-left: 3px solid #ff9800;
    }
    .appt-table td {
        padding: 16px 18px;
        vertical-align: middle;
        font-size: 14px;
        color: #ddd;
    }

    /* Expand row */
    .detail-row {
        display: none;
        background: rgba(12,10,8,0.85);
        border-top: 1px dashed rgba(216,182,122,0.12);
    }
    .detail-row.open {
        display: table-row;
    }
    .detail-row td {
        padding: 0;
    }
    .detail-panel {
        padding: 24px 30px;
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 28px;
        align-items: start;
    }

    /* Payment detail fields */
    .pay-field-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px 24px;
    }
    .pay-field label {
        display: block;
        font-size: 10px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 4px;
    }
    .pay-field .val {
        color: #f0ece6;
        font-weight: 600;
        font-size: 14px;
    }
    .pay-field .val.gold { color: #d8b67a; }
    .pay-field .val.mono { font-family: monospace; font-size: 13px; }

    /* Proof image */
    .proof-img-wrap {
        flex-shrink: 0;
        text-align: center;
    }
    .proof-img-wrap img {
        width: 160px;
        height: 130px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid rgba(216,182,122,0.3);
        cursor: pointer;
        transition: transform 0.25s, box-shadow 0.25s;
        display: block;
    }
    .proof-img-wrap img:hover {
        transform: scale(1.04);
        box-shadow: 0 8px 24px rgba(216,182,122,0.15);
    }
    .proof-img-wrap a {
        display: block;
        font-size: 11px;
        color: #d8b67a;
        text-decoration: underline;
        margin-top: 6px;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .badge-approved  { background:rgba(216,182,122,0.18); color:#d8b67a; border:1px solid rgba(216,182,122,0.35); }
    .badge-rejected  { background:rgba(120,70,55,0.22); color:#e0a58f; border:1px solid rgba(224,165,143,0.28); }
    .badge-completed { background:rgba(255,255,255,0.08); color:#e8d8c0; border:1px solid rgba(255,255,255,0.14); }
    .badge-pending   { background:#4a3a18; color:#ffd77d; }
    .pay-completed   { background:rgba(76,175,80,0.15); color:#4caf50; border:1px solid rgba(76,175,80,0.3); }
    .pay-pending     { background:rgba(255,152,0,0.15); color:#ff9800; border:1px solid rgba(255,152,0,0.3); }
    .pay-cancelled   { background:rgba(244,67,54,0.15); color:#f44336; border:1px solid rgba(244,67,54,0.3); }
    .pay-none        { background:rgba(100,100,100,0.12); color:#666; border:1px solid rgba(100,100,100,0.2); font-style:italic; }

    /* Summary badge in main row */
    .pay-summary {
        font-size: 13px;
        font-weight: 700;
        color: #d8b67a;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .pay-summary .method-tag {
        font-size: 11px;
        color: #888;
        font-weight: 400;
    }
    .expand-btn {
        background: none;
        border: 1px solid rgba(216,182,122,0.25);
        color: #d8b67a;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        margin-top: 6px;
        white-space: nowrap;
    }
    .expand-btn:hover { background: rgba(216,182,122,0.1); }
    .expand-btn .arrow { transition: transform 0.2s; display: inline-block; }
    .expand-btn.active .arrow { transform: rotate(180deg); }

    /* Action buttons */
    .btn-approve {
        background: rgba(76,175,80,0.15);
        color: #4caf50;
        border: 1px solid rgba(76,175,80,0.35);
        padding: 9px 14px;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s;
        white-space: nowrap;
        width: 100%;
        text-align: left;
        line-height: 1.4;
    }
    .btn-approve:hover { background: rgba(76,175,80,0.28); }
    .btn-reject {
        background: rgba(244,67,54,0.1);
        color: #f44336;
        border: 1px solid rgba(244,67,54,0.3);
        padding: 9px 14px;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s;
        white-space: nowrap;
        width: 100%;
        text-align: left;
        line-height: 1.4;
    }
    .btn-reject:hover { background: rgba(244,67,54,0.2); }
    .btn-delete {
        background: rgba(90,45,45,0.18);
        color: #d9a29a;
        border: 1px solid rgba(217,162,154,0.22);
        padding: 7px 12px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s;
        width: 100%;
    }
    .btn-delete:hover { background: rgba(90,45,45,0.35); }
    .actions-cell {
        display: flex;
        flex-direction: column;
        gap: 7px;
        min-width: 140px;
    }

    /* Lightbox overlay */
    #lightbox-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.88);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(6px);
    }
    #lightbox-overlay.open { display: flex; }
    #lightbox-overlay img {
        max-width: 90vw;
        max-height: 88vh;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.7);
    }
    #lightbox-close {
        position: fixed;
        top: 20px;
        right: 28px;
        color: #fff;
        font-size: 36px;
        cursor: pointer;
        line-height: 1;
        z-index: 10000;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    #lightbox-close:hover { opacity: 1; }

    /* Appointment notes in detail */
    .appt-notes-box {
        background: rgba(216,182,122,0.05);
        border: 1px dashed rgba(216,182,122,0.2);
        border-radius: 8px;
        padding: 10px 14px;
        color: #c4bbb0;
        font-size: 13px;
        font-style: italic;
        margin-top: 6px;
    }
</style>

{{-- Lightbox --}}
<div id="lightbox-overlay" onclick="closeLightbox()">
    <span id="lightbox-close" onclick="closeLightbox()">×</span>
    <img id="lightbox-img" src="" alt="Bukti Pembayaran">
</div>

<div style="min-height:100vh; background:#0f0d0c; color:white; padding:60px 40px; font-family:'Poppins', sans-serif;">
    <div style="max-width:1400px; margin:auto;">

        <h1 style="color:#d8b67a; font-size:42px; margin-bottom:8px;">Appointments & Pembayaran</h1>
        <p style="color:#8e857b; margin:0 0 30px; font-size:15px;">
            Klik <strong style="color:#d8b67a;">▼ Lihat Detail Bayar</strong> untuk melihat semua informasi yang diisi customer. Klik <strong style="color:#4caf50;">Approve</strong> untuk menyetujui appointment sekaligus mengkonfirmasi pembayarannya dalam satu aksi.
        </p>

        @if(session('success'))
            <div style="background:rgba(76,175,80,0.12); color:#4caf50; border:1px solid rgba(76,175,80,0.3); padding:14px 20px; border-radius:14px; margin-bottom:25px; font-weight:bold; display:flex; align-items:center; gap:10px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="appt-table-wrap">
            <table class="appt-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Service & Stylist</th>
                        <th>Tanggal & Jam</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        @php $pay = $appointment->latestPayment; $idx = $loop->index; @endphp

                        {{-- Main row --}}
                        <tr class="main-row {{ $appointment->status === 'pending' ? 'row-pending' : '' }}">

                            {{-- No --}}
                            <td style="color:#555; font-size:13px;">{{ $loop->iteration }}</td>

                            {{-- Customer --}}
                            <td>
                                <div style="font-weight:600; color:#fff;">{{ $appointment->user->name ?? '-' }}</div>
                                <div style="font-size:12px; color:#666; margin-top:2px;">{{ $appointment->user->email ?? '' }}</div>
                            </td>

                            {{-- Service & Stylist --}}
                            <td>
                                <div style="font-weight:600; color:#d8b67a;">{{ $appointment->service->name ?? '-' }}</div>
                                <div style="font-size:12px; color:#888; margin-top:2px;">{{ $appointment->stylist->name ?? '-' }}</div>
                            </td>

                            {{-- Date & Time --}}
                            <td>
                                <div style="font-weight:600; color:#fff;">{{ $appointment->appointment_date }}</div>
                                <div style="font-size:12px; color:#888;">{{ $appointment->appointment_time }} WIB</div>
                                @if($appointment->notes)
                                    <div style="font-size:11px; color:#666; margin-top:4px; font-style:italic;" title="{{ $appointment->notes }}">
                                        📝 {{ Str::limit($appointment->notes, 30) }}
                                    </div>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($appointment->status === 'approved')
                                    <span class="badge badge-approved">✓ APPROVED</span>
                                @elseif($appointment->status === 'rejected')
                                    <span class="badge badge-rejected">✕ REJECTED</span>
                                @elseif($appointment->status === 'completed')
                                    <span class="badge badge-completed">★ COMPLETED</span>
                                @else
                                    <span class="badge badge-pending">⏳ PENDING</span>
                                @endif
                            </td>

                            {{-- Payment summary + expand --}}
                            <td>
                                @if($pay)
                                    <div class="pay-summary">
                                        <span class="gold">Rp {{ number_format($pay->amount, 0, ',', '.') }}</span>
                                        <span class="method-tag">{{ strtoupper($pay->payment_method) }}</span>
                                        @if($pay->status === 'completed')
                                            <span class="badge pay-completed" style="font-size:10px; padding:3px 9px;">✓ LUNAS</span>
                                        @elseif($pay->status === 'pending')
                                            <span class="badge pay-pending" style="font-size:10px; padding:3px 9px;">⏳ MENUNGGU</span>
                                        @else
                                            <span class="badge pay-cancelled" style="font-size:10px; padding:3px 9px;">✕ BATAL</span>
                                        @endif
                                    </div>
                                    <button class="expand-btn" onclick="toggleDetail({{ $idx }})" id="expand-btn-{{ $idx }}">
                                        <span class="arrow">▼</span> Lihat Detail Bayar
                                    </button>
                                @else
                                    <span class="badge pay-none">— Belum Bayar</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="actions-cell">
                                    @if($appointment->status === 'pending')
                                        <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn-approve">
                                                ✓ Approve
                                                @if($pay)<span style="display:block;font-size:10px;font-weight:400;opacity:0.8;">+ Konfirmasi Bayar</span>@endif
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn-reject" onclick="return confirm('Yakin ingin menolak appointment ini?')">
                                                ✕ Reject
                                                @if($pay)<span style="display:block;font-size:10px;font-weight:400;opacity:0.8;">+ Batalkan Bayar</span>@endif
                                            </button>
                                        </form>
                                    @else
                                        <span style="color:#444; font-size:11px; font-style:italic; display:block; margin-bottom:4px;">Sudah diproses</span>
                                    @endif

                                    <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus appointment ini?')" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">🗑 Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Expandable payment detail row --}}
                        @if($pay)
                        <tr class="detail-row" id="detail-row-{{ $idx }}">
                            <td colspan="7">
                                <div class="detail-panel">

                                    {{-- Proof image (left) --}}
                                    @if($pay->proof_image)
                                    <div class="proof-img-wrap">
                                        <img
                                            src="{{ asset('storage/payments/' . $pay->proof_image) }}"
                                            alt="Bukti Pembayaran"
                                            onclick="openLightbox('{{ asset('storage/payments/' . $pay->proof_image) }}')"
                                            title="Klik untuk perbesar"
                                        >
                                        <a href="{{ asset('storage/payments/' . $pay->proof_image) }}" target="_blank">Buka di tab baru ↗</a>
                                        <div style="font-size:10px; color:#555; margin-top:4px;">Klik gambar untuk perbesar</div>
                                    </div>
                                    @else
                                    <div class="proof-img-wrap" style="width:160px;">
                                        <div style="width:160px; height:130px; border-radius:12px; border:1px dashed rgba(216,182,122,0.2); display:flex; align-items:center; justify-content:center; color:#444; font-size:12px; flex-direction:column; gap:6px;">
                                            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Tidak ada bukti
                                        </div>
                                    </div>
                                    @endif

                                    {{-- All payment fields (right) --}}
                                    <div>
                                        <div style="font-size:11px; letter-spacing:2px; color:#d8b67a; text-transform:uppercase; font-weight:700; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            Detail Pembayaran Customer
                                        </div>

                                        <div class="pay-field-grid">
                                            <div class="pay-field">
                                                <label>Jumlah Pembayaran</label>
                                                <div class="val gold" style="font-size:18px;">Rp {{ number_format($pay->amount, 0, ',', '.') }}</div>
                                            </div>
                                            <div class="pay-field">
                                                <label>Metode Pembayaran</label>
                                                <div class="val">
                                                    @if($pay->payment_method === 'qris') QRIS
                                                    @elseif($pay->payment_method === 'transfer') Transfer Bank
                                                    @elseif($pay->payment_method === 'card') Kartu Kredit/Debit
                                                    @else {{ ucfirst($pay->payment_method) }}
                                                    @endif
                                                </div>
                                            </div>
                                            @if($pay->bank_account)
                                            <div class="pay-field">
                                                <label>Rekening / No. Akun Pengirim</label>
                                                <div class="val mono">{{ $pay->bank_account }}</div>
                                            </div>
                                            @endif
                                            @if($pay->transaction_id)
                                            <div class="pay-field">
                                                <label>ID Transaksi / Referensi</label>
                                                <div class="val mono">{{ $pay->transaction_id }}</div>
                                            </div>
                                            @endif
                                            <div class="pay-field">
                                                <label>Status Pembayaran</label>
                                                <div class="val">
                                                    @if($pay->status === 'completed')
                                                        <span class="badge pay-completed">✓ LUNAS</span>
                                                    @elseif($pay->status === 'pending')
                                                        <span class="badge pay-pending">⏳ MENUNGGU KONFIRMASI</span>
                                                    @else
                                                        <span class="badge pay-cancelled">✕ DIBATALKAN</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="pay-field">
                                                <label>Tanggal Pengajuan</label>
                                                <div class="val" style="font-weight:400; color:#bbb;">{{ $pay->created_at->format('d M Y, H:i') }} WIB</div>
                                            </div>
                                        </div>

                                        @if($pay->notes)
                                        <div style="margin-top:16px;">
                                            <div style="font-size:10px; letter-spacing:1.5px; color:#888; text-transform:uppercase; margin-bottom:6px;">Catatan dari Customer</div>
                                            <div class="appt-notes-box">{{ $pay->notes }}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif

                    @endforeach
                </tbody>
            </table>

            @if($appointments->isEmpty())
                <div style="padding:60px; text-align:center; color:#555;">
                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px; display:block; opacity:0.4;"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p style="font-size:16px; margin:0;">Belum ada data appointment.</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
    function toggleDetail(idx) {
        const row = document.getElementById('detail-row-' + idx);
        const btn = document.getElementById('expand-btn-' + idx);
        if (row.classList.contains('open')) {
            row.classList.remove('open');
            btn.classList.remove('active');
            btn.querySelector('.arrow').textContent = '▼';
        } else {
            row.classList.add('open');
            btn.classList.add('active');
            btn.querySelector('.arrow').textContent = '▲';
        }
    }

    function openLightbox(src) {
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox-overlay').classList.remove('open');
        document.getElementById('lightbox-img').src = '';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox();
    });
</script>

@endsection