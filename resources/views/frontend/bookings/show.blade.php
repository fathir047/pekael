@extends('layouts.frontend')

@section('content')
<div class="container-fluid mt-5" style="margin-top:100px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Detail Booking</h5>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama</label>
                <p class="form-control-plaintext">{{ auth()->user()->name }}</p>
            </div>

            @foreach($booking as $data) 

            <div class="mb-3">
                <label class="form-label fw-bold">Ruangan</label>
                <p class="form-control-plaintext">{{ $data->ruangan->nama }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal</label>
                <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('l, j F Y') }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Jam</label>
                <p class="form-control-plaintext">{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <span class="badge 
                    @if($data->status === 'Diterima') bg-success 
                    @elseif($data->status === 'Ditolak') bg-danger 
                    @else bg-warning text-dark 
                    @endif">
                    {{ $data->status }}
                </span>
            </div>
            
            @endforeach 

            <div class="d-flex justify-content-end">
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">Buat Booking Baru</a>
            </div>
        </div>
    </div>
</div>
@endsection
