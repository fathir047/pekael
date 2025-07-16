@extends('layouts.frontend')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-check-fill me-2"></i>
                        Form Booking Ruangan
                    </h5>
                </div> 

                <div class="card-body p-4">
                    <form action="{{ route('frontend.bookings.store') }}" method="POST">
                        @csrf

                        {{-- Nama Pengguna --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        {{-- Pilih Ruangan --}}
                        <div class="mb-3">
                            <label for="ruang_id" class="form-label">Ruangan</label>
                            <select name="ruang_id" id="ruang_id" class="form-select @error('ruang_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach ($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}" {{ old('ruang_id') == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ruang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal --}}
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                value="{{ old('tanggal') }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jam Mulai --}}
                        <div class="mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror"
                                value="{{ old('jam_mulai') }}" required>
                            @error('jam_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jam Selesai --}}
                        <div class="mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror"
                                value="{{ old('jam_selesai') }}" required>
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('home') }}" class="btn btn-secondary me-2">
                                <i class="bi bi-arrow-left-circle me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-check me-1"></i> Ajukan Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
