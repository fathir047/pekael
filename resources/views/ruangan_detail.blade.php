@extends('layouts.frontend')

@section('content')
<div class="detail-wrapper">
    <div class="container-lg py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card detail-card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="row g-0 flex-column flex-md-row">
                        <div class="col-12 col-md-6 image-section">
                            @if($ruangan->cover)
                                <img src="{{ asset('storage/'.$ruangan->cover) }}" 
                                     class="w-100 h-100 object-fit-cover" 
                                     alt="Ruangan {{ $ruangan->nama }}">
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                    <div class="text-center text-muted p-4">
                                        <i class="bi bi-image" style="font-size: clamp(32px, 8vw, 64px);"></i>
                                        <p class="mt-2">Tidak ada gambar</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    
                        <div class="col-12 col-md-6 content-section">
                            <div class="card-body p-3 p-sm-4 p-lg-5">
                                <h1 class="card-title mb-3 mb-md-4">{{ $ruangan->nama }}</h1>
                                
                                <div class="capacity-section mb-4">
                                    <div class="capacity-box">
                                        <div class="bg-light rounded-3 p-3 p-sm-4 text-center">
                                            <div class="text-muted small">Kapasitas</div>
                                            <div class="fw-bold">{{ $ruangan->kapasitas }} Orang</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="facilities-section mb-4 mb-md-5">
                                    <h5 class="mb-3">Fasilitas</h5>
                                    <div class="row g-2">
                                        @foreach(array_filter(preg_split('/\r\n|\r|\n/', $ruangan->fasilitas)) as $item)
                                            <div class="col-auto">
                                                <span class="badge bg-primary-subtle text-primary border border-primary rounded-pill px-2 px-sm-3 py-2">
                                                    {{ $item }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="button-section d-grid gap-2">
                                    <a href="{{ route('bookings.create', ['ruang_id' => $ruangan->id]) }}"
                                        class="btn btn-primary btn-lg fw-semibold">
                                        📅 Booking Sekarang
                                    </a>
                                    <a href="{{ route('ruangan.show') }}"
                                        class="btn btn-outline-secondary">
                                        ← Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

{{-- CSS --}}
<style>
    :root {
        --primary: #0d6efd;
        --primary-light: #e7f1ff;
        --shadow-md: 0 8px 16px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.12);
        --radius-md: 12px;
        --radius-lg: 20px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .detail-wrapper {
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

    .detail-card {
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        animation: slideUp 0.4s ease-out;
    }

    .image-section {
        position: relative;
        min-height: clamp(200px, 50vw, 400px);
        background: #e9ecef;
        overflow: hidden;
    }

    .image-section img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .detail-card:hover .image-section img {
        transform: scale(1.05);
    }

    .content-section {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-body {
        padding: clamp(20px, 4vw, 40px);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-title {
        font-size: clamp(20px, 4vw, 32px);
        font-weight: 700;
        color: #212529;
        margin-bottom: clamp(16px, 3vw, 24px);
    }

    .capacity-section {
        margin-bottom: clamp(20px, 4vw, 30px);
    }

    .capacity-box {
        padding: clamp(12px, 2vw, 16px);
    }

    .capacity-box .bg-light {
        padding: clamp(16px, 3vw, 24px) !important;
        border-radius: var(--radius-lg);
    }

    .capacity-box .text-muted {
        font-size: clamp(12px, 1.8vw, 14px);
        margin-bottom: clamp(4px, 1vw, 8px);
    }

    .capacity-box .fw-bold {
        font-size: clamp(16px, 3vw, 24px);
        color: var(--primary);
    }

    .facilities-section {
        margin-bottom: clamp(24px, 5vw, 40px);
    }

    .facilities-section h5 {
        font-size: clamp(14px, 2.5vw, 18px);
        font-weight: 600;
        margin-bottom: clamp(12px, 2vw, 16px);
        color: #212529;
    }

    .badge {
        font-size: clamp(11px, 1.5vw, 13px);
        padding: clamp(4px 8px, 1.2vw 2vw, 6px 12px);
        white-space: normal;
        word-break: break-word;
    }

    .button-section {
        margin-top: auto;
    }

    .btn-primary,
    .btn-outline-secondary {
        font-size: clamp(13px, 2vw, 15px);
        padding: clamp(10px 16px, 1.5vw 2.5vw, 12px 20px);
        border-radius: var(--radius-md);
        transition: var(--transition);
        font-weight: 500;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #0a58ca;
        border-color: #0a58ca;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3);
    }

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
        transform: translateY(-2px);
    }

    .btn-lg {
        padding: clamp(12px 20px, 1.8vw 3vw, 14px 24px) !important;
    }

    /* ANIMATIONS */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        .detail-wrapper {
            padding-top: clamp(50px, 12vw, 80px);
            padding-bottom: clamp(30px, 6vw, 50px);
        }

        .image-section {
            min-height: clamp(180px, 40vw, 300px);
        }

        .card-body {
            padding: clamp(16px, 3vw, 24px);
        }

        .facilities-section {
            margin-bottom: clamp(20px, 4vw, 30px);
        }

        .button-section {
            gap: 8px !important;
        }
    }

    @media (max-width: 576px) {
        .detail-wrapper {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: clamp(40px, 10vw, 70px);
        }

        .image-section {
            min-height: clamp(150px, 35vw, 250px);
        }

        .card-body {
            padding: 12px !important;
        }

        .card-title {
            font-size: clamp(16px, 3.5vw, 22px);
        }

        .capacity-box .bg-light {
            padding: 12px !important;
        }

        .button-section .btn {
            font-size: clamp(12px, 1.8vw, 14px);
            padding: clamp(8px 12px, 1.2vw 2vw, 10px 16px) !important;
        }
    }

    @media (max-width: 380px) {
        .detail-wrapper {
            padding-left: 8px;
            padding-right: 8px;
        }

        .card-title {
            font-size: 16px;
        }

        .card-body {
            padding: 10px !important;
        }
    }
</style>
@endsection