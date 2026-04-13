@extends('layouts.frontend')

@section('content')
<div class="riwayat-wrapper">
    <div class="container-lg py-4 py-md-5">
        <div class="section-header mb-4 mb-md-5">
            <h2 class="section-title mb-0">Riwayat Booking Anda</h2>
        </div>

        @if($booking->count())
            <!-- DESKTOP VIEW (TABLE) -->
            <div class="table-view d-none d-md-block">
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th style="font-size: clamp(12px, 1.8vw, 14px);">#</th>
                                <th style="font-size: clamp(12px, 1.8vw, 14px);">Ruangan</th>
                                <th style="font-size: clamp(12px, 1.8vw, 14px);">Tanggal</th>
                                <th style="font-size: clamp(12px, 1.8vw, 14px);">Waktu</th>
                                <th style="font-size: clamp(12px, 1.8vw, 14px);">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking as $index => $data)
                                <tr>
                                    <td style="font-size: clamp(11px, 1.6vw, 13px);">{{ $index + 1 }}</td>
                                    <td style="font-size: clamp(11px, 1.6vw, 13px);">
                                        <strong>{{ $data->ruangan->nama }}</strong>
                                    </td>
                                    <td style="font-size: clamp(11px, 1.6vw, 13px);">
                                        {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('l, d F Y') }}
                                    </td>
                                    <td style="font-size: clamp(11px, 1.6vw, 13px);">
                                        {{ $data->jam_mulai }} - {{ $data->jam_selesai }}
                                    </td>
                                    <td style="font-size: clamp(11px, 1.6vw, 13px);">
                                        @switch($data->status)
                                            @case('Pending')
                                                <span class="badge bg-light text-dark">Menunggu</span>
                                                @break
                                            @case('Diterima') 
                                                <span class="badge bg-primary">Disetujui</span>
                                                @break
                                            @case('Ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                            @case('Selesai')
                                                <span class="badge bg-success">Selesai</span>
                                                @break
                                            @default
                                                <span class="badge bg-warning">Tidak Diketahui</span>
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MOBILE VIEW (CARDS) -->
            <div class="card-view d-md-none">
                <div class="row g-3">
                    @foreach($booking as $index => $data)
                        <div class="col-12">
                            <div class="booking-card">
                                <div class="booking-card-header">
                                    <div class="booking-number">#{{ $index + 1 }}</div>
                                    <div class="booking-status">
                                        @switch($data->status)
                                            @case('Pending')
                                                <span class="badge bg-light text-dark">Menunggu</span>
                                                @break
                                            @case('Diterima') 
                                                <span class="badge bg-primary">Disetujui</span>
                                                @break
                                            @case('Ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                            @case('Selesai')
                                                <span class="badge bg-success">Selesai</span>
                                                @break
                                            @default
                                                <span class="badge bg-warning">Tidak Diketahui</span>
                                        @endswitch
                                    </div>
                                </div>

                                <div class="booking-body">
                                    <div class="booking-item">
                                        <span class="booking-label">Ruangan</span>
                                        <span class="booking-value">{{ $data->ruangan->nama }}</span>
                                    </div>

                                    <div class="booking-item">
                                        <span class="booking-label">Tanggal</span>
                                        <span class="booking-value">
                                            {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('l, d F Y') }}
                                        </span>
                                    </div>

                                    <div class="booking-item">
                                        <span class="booking-label">Waktu</span>
                                        <span class="booking-value">
                                            {{ $data->jam_mulai }} - {{ $data->jam_selesai }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h5>Belum ada riwayat booking</h5>
                <p>Anda belum melakukan pemesanan ruangan. Mulai booking sekarang!</p>
                <a href="{{ route('bookings.create') }}" class="btn btn-primary mt-3">
                    Booking Ruangan
                </a>
            </div>
        @endif
    </div>
</div>

{{-- CSS --}}
<style>
    :root {
        --primary: #0d6efd;
        --success: #198754;
        --danger: #dc3545;
        --warning: #ffc107;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 8px 16px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .riwayat-wrapper {
        padding-top: clamp(60px, 15vw, 100px);
        padding-bottom: clamp(40px, 8vw, 60px);
        padding-left: clamp(12px, 3vw, 20px);
        padding-right: clamp(12px, 3vw, 20px);
        background: #f8f9fa;
        min-height: 100vh;
    }

    .container-lg {
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-header {
        text-align: center;
    }

    .section-title {
        font-size: clamp(20px, 5vw, 36px);
        font-weight: 700;
        color: #212529;
    }

    /* ============= DESKTOP TABLE VIEW ============= */
    .table-responsive {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .table {
        margin-bottom: 0;
    }

    .table thead.table-primary {
        background-color: var(--primary);
        color: white;
    }

    .table thead th {
        font-weight: 600;
        padding: clamp(12px, 2vw, 16px);
        border: none;
        vertical-align: middle;
    }

    .table tbody td {
        font-size: clamp(11px, 1.6vw, 13px);
        padding: clamp(12px, 1.5vw, 14px);
        vertical-align: middle;
        border-color: #e9ecef;
    }

    .table tbody tr {
        transition: var(--transition);
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge {
        font-size: clamp(10px, 1.3vw, 12px);
        padding: clamp(4px 8px, 0.8vw 1.5vw, 5px 10px);
    }

    /* ============= MOBILE CARD VIEW ============= */
    .booking-card {
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: var(--transition);
        animation: slideUp 0.3s ease-out;
    }

    .booking-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .booking-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: clamp(12px, 3vw, 16px);
        background: linear-gradient(135deg, var(--primary), #0a58ca);
        color: white;
    }

    .booking-number {
        font-weight: 700;
        font-size: clamp(14px, 2vw, 16px);
    }

    .booking-status .badge {
        font-size: clamp(11px, 1.5vw, 12px);
    }

    .booking-body {
        padding: clamp(12px, 3vw, 16px);
    }

    .booking-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: clamp(10px, 2vw, 12px) 0;
        border-bottom: 1px solid #e9ecef;
    }

    .booking-item:last-child {
        border-bottom: none;
    }

    .booking-label {
        font-weight: 600;
        font-size: clamp(12px, 1.8vw, 13px);
        color: #6c757d;
        min-width: 80px;
    }

    .booking-value {
        font-weight: 500;
        font-size: clamp(12px, 1.8vw, 13px);
        color: #212529;
        text-align: right;
        flex-grow: 1;
    }

    /* ============= EMPTY STATE ============= */
    .empty-state {
        text-align: center;
        padding: clamp(40px, 8vw, 60px) clamp(20px, 4vw, 40px);
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
    }

    .empty-icon {
        font-size: clamp(48px, 12vw, 80px);
        margin-bottom: clamp(16px, 3vw, 24px);
    }

    .empty-state h5 {
        font-size: clamp(16px, 3vw, 20px);
        font-weight: 600;
        color: #212529;
        margin-bottom: clamp(8px, 1.5vw, 12px);
    }

    .empty-state p {
        font-size: clamp(13px, 2vw, 15px);
        color: #6c757d;
        margin-bottom: clamp(12px, 2vw, 16px);
    }

    .btn-primary {
        font-size: clamp(13px, 2vw, 15px);
        padding: clamp(10px 20px, 1.5vw 2.5vw, 12px 24px);
        border-radius: 8px;
        transition: var(--transition);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3);
    }

    /* ============= ANIMATIONS ============= */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ============= RESPONSIVE ============= */
    @media (max-width: 992px) {
        .section-title {
            font-size: clamp(18px, 4vw, 28px);
        }

        .table {
            font-size: 12px;
        }

        .table thead th,
        .table tbody td {
            padding: clamp(10px, 1.5vw, 12px);
        }
    }

    @media (max-width: 768px) {
        .riwayat-wrapper {
            padding-top: clamp(50px, 12vw, 80px);
            padding-bottom: clamp(30px, 6vw, 50px);
        }

        .section-title {
            font-size: clamp(16px, 3.5vw, 24px);
        }
    }

    @media (max-width: 576px) {
        .riwayat-wrapper {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: clamp(40px, 10vw, 70px);
        }

        .section-title {
            font-size: 18px;
        }

        .booking-card-header {
            padding: 10px 12px;
        }

        .booking-body {
            padding: 10px 12px;
        }

        .booking-item {
            padding: 8px 0;
            flex-direction: column;
            gap: 4px;
        }

        .booking-label {
            text-align: left;
        }

        .booking-value {
            text-align: left;
        }
    }

    @media (max-width: 380px) {
        .riwayat-wrapper {
            padding-left: 8px;
            padding-right: 8px;
        }

        .section-title {
            font-size: 16px;
        }

        .booking-number {
            font-size: 13px;
        }

        .empty-state {
            padding: 30px 15px;
        }
    }
</style>
@endsection