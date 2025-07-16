@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <b>Detail Ruangan</b>
                </div>
                <div class="card-body">
                    
                    {{-- Foto --}}
                    <div class="mb-3">
                        <label class="form-label">Foto</label><br>
                        @if($ruangan->cover)
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $ruangan->cover) }}" width="500px" alt="Cover" class="img-fluid rounded">
                            </div>
                        @else
                            <p class="text-muted">Tidak ada foto</p>
                        @endif
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" class="form-control" value="{{ $ruangan->nama }}" disabled>
                    </div>

                    {{-- Kapasitas --}}
                    <div class="mb-3">
                        <label class="form-label">Kapasitas Ruangan</label>
                        <input type="number" class="form-control" value="{{ $ruangan->kapasitas }}" disabled>
                    </div>

                    {{-- Fasilitas --}}
                    <div class="mb-3">
                        <label class="form-label">Fasilitas Ruangan</label>
                        <textarea class="form-control" rows="4" disabled>{{ $ruangan->fasilitas }}</textarea>
                    </div>

                    {{-- Tombol --}}
                    <div class="mt-4">
                        <a href="{{ route('backend.ruangan.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        <a href="{{ route('backend.ruangan.edit', $ruangan->id) }}" class="btn btn-outline-warning ms-2">Edit</a>
                    </div>

                </div>
            </div>
        </div>
    </div> 
</div>
@endsection
