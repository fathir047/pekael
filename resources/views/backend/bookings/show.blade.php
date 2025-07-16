
@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Detail Booking</h5>
        </div>

        <div class="card-body">
            <p><strong>Nama:</strong> {{ $booking->user->name }}</p>
            <p><strong>Ruangan:</strong> {{ $booking->ruangan->nama }}</p>
            <p><strong>Tanggal:</strong> {{ $booking->tanggal_format }}</p>
            <p><strong>Jam:</strong> {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</p>
            <p><strong>Status:</strong> {{ $booking->status }}</p>
            <a href="{{ route('backend.bookings.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div> 
@endsection