@extends('layouts.frontend')

@section('content')
<div class="card" style="padding-top:100px;">
    <div class="container py-5" >
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Daftar Ruangan</h2>
        </div>

        <div class="row g-4">
            @foreach($ruangan as $data)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm transition-all duration-300 hover-shadow-lg hover-transform-up">
                    @if($data->cover)
                    <div class="ratio ratio-16x9">
                        <img src="{{ asset('storage/'.$data->cover) }}" class="card-img-top object-fit-cover" alt="data {{ $data->nama }}">
                    </div>
                    @endif
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="h5 fw-bold mb-0">{{ $data->nama }}</h3>
                            
                        </div>
                        <div class="d-flex align-items-start mb-2">
                            <span>Kapasitas : </span>
                            <span class="badge bg-primary" style="shadow"> {{ $data->kapasitas }}</span>
                        </div>
                         
                        <div class="mb-3">
                            <h6 class="text-uppercase text-muted small mb-2">Fasilitas</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(' ', $data->fasilitas) as $fasilitas)
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                                        {{ trim($fasilitas) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent border-top-0 pt-0 pb-3">
                        <a href="{{ route('ruangan.detail', $data->id) }}" class="btn btn-outline-primary w-0">
                            <i class="ti ti-eye"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    
    </div>
</div>

@endsection

@push('styles')
<style>
    .hover-shadow-lg:hover {
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
    }
    .hover-transform-up:hover {
        transform: translateY(-5px);
    }
    .transition-all {
        transition: all 0.25s ease;
    }
</style>
@endpush