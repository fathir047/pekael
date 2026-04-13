@extends('layouts.frontend')

@section('content')
<div class="ruangan-wrapper">
    <div class="container-fluid">
        <div class="py-4 py-md-5">
            <div class="text-center mb-4 mb-md-5">
                <h2 class="display-title fw-bold">Daftar Ruangan</h2>
            </div>

            <div class="row g-3 g-md-4">
                @foreach($ruangan as $data)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card ruangan-card h-100 border-0 shadow-sm">
                        @if($data->cover)
                        <div class="ratio-wrapper">
                            <img src="{{ asset('storage/'.$data->cover) }}" 
                                 class="card-img-top object-fit-cover" 
                                 alt="Ruangan {{ $data->nama }}">
                        </div>
                        @else
                        <div class="ratio-wrapper bg-light d-flex align-items-center justify-content-center">
                            <div class="text-center text-muted">
                                <i class="bi bi-image" style="font-size: clamp(24px, 5vw, 48px);"></i>
                                <p class="mt-2 small mb-0">Tidak ada gambar</p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="card-body p-3 p-sm-4">
                            <h3 class="card-title h5 fw-bold mb-2">{{ $data->nama }}</h3>
                            
                            <div class="capacity-badge mb-3">
                                <span class="badge bg-primary">
                                    <i class="bi bi-people"></i>
                                    {{ $data->kapasitas }} Orang
                                </span>
                            </div>
                             
                            <div class="mb-3">
                                <h6 class="text-uppercase text-muted small mb-2">Fasilitas</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(array_filter(preg_split('/\r\n|\r|\n/', $data->fasilitas)) as $fasilitas)
                                        <span class="badge bg-light text-dark border small">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i>
                                            {{ trim($fasilitas) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent border-top-0 pt-0 pb-3 px-3 px-sm-4">
                            <a href="{{ route('ruangan.detail', $data->id) }}" class="btn btn-outline-primary w-100">
                                <i class="ti ti-eye"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- CSS --}}
<style>
    :root {
        --primary: #0d6efd;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 8px 16px rgba(0, 0, 0, 0.1);
        --radius-md: 12px;
        --radius-lg: 16px;
    }

    .ruangan-wrapper {
        padding-top: clamp(60px, 15vw, 100px);
        padding-bottom: clamp(40px, 8vw, 60px);
        background: #f8f9fa;
        min-height: 100vh;
    }

    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
        padding-left: clamp(12px, 3vw, 30px);
        padding-right: clamp(12px, 3vw, 30px);
    }

    .display-title {
        font-size: clamp(24px, 6vw, 48px);
        color: #212529;
        margin-bottom: clamp(16px, 3vw, 24px);
    }

    .ruangan-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    .ruangan-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-md) !important;
    }

    .ratio-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background: #e9ecef;
    }

    .ratio-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .ruangan-card:hover .ratio-wrapper img {
        transform: scale(1.05);
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: clamp(14px, 2.5vw, 18px);
        margin-bottom: clamp(8px, 1.5vw, 12px);
        color: #212529;
    }

    .capacity-badge {
        margin-bottom: clamp(12px, 2vw, 16px);
    }

    .capacity-badge .badge {
        font-size: clamp(12px, 1.8vw, 14px);
        padding: clamp(4px 8px, 1vw 2vw, 6px 12px);
    }

    .badge {
        font-size: clamp(11px, 1.5vw, 13px);
        padding: clamp(3px 6px, 0.8vw 1.5vw, 5px 10px);
        margin-bottom: clamp(4px, 0.8vw, 6px);
        display: inline-block;
    }

    .badge.bg-light {
        white-space: normal;
        word-break: break-word;
    }

    .badge i {
        font-size: clamp(10px, 1.3vw, 12px);
    }

    .card-footer {
        flex-grow: 1;
        display: flex;
        align-items: flex-end;
    }

    .btn-outline-primary {
        font-size: clamp(13px, 2vw, 15px);
        padding: clamp(8px 12px, 1.5vw 2.5vw, 10px 16px);
        border-radius: var(--radius-md);
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary);
        color: white;
        transform: scale(1.02);
    }

    /* RESPONSIVE GRID */
    @media (max-width: 1200px) {
        .ruangan-wrapper {
            padding-top: clamp(50px, 12vw, 80px);
        }
    }

    @media (max-width: 768px) {
        .ruangan-wrapper {
            padding-top: clamp(40px, 10vw, 70px);
            padding-bottom: clamp(30px, 6vw, 50px);
        }

        .display-title {
            font-size: clamp(20px, 5vw, 32px);
            margin-bottom: clamp(12px, 2vw, 20px);
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        .ruangan-wrapper {
            padding-top: clamp(30px, 8vw, 60px);
            padding-bottom: clamp(20px, 5vw, 40px);
        }

        .display-title {
            font-size: clamp(18px, 4vw, 24px);
        }

        .card-body {
            padding: 12px !important;
        }

        .card-footer {
            padding: 0 12px 12px 12px !important;
        }

        .ratio-wrapper {
            aspect-ratio: 16 / 9;
        }
    }

    @media (max-width: 380px) {
        .container-fluid {
            padding-left: 8px;
            padding-right: 8px;
        }

        .display-title {
            font-size: 16px;
        }

        .card-title {
            font-size: 13px;
        }
    }

    /* ANIMATIONS */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ruangan-card {
        animation: fadeIn 0.4s ease-out;
    }
</style>
@endsection