@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <b>Detail Jadwal</b>
                </div>
                <div class="card-body">

                    {{-- Ruangan --}}
                    <div class="mb-3">
                        <label class="form-label">Ruangan</label>
                        <input type="text" class="form-control" value="{{ $jadwal->ruangan->nama }}" disabled>
                    </div>
 
                    {{-- Tanggal --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="text" class="form-control" value="{{ $jadwal->tanggal_format }}" disabled>
                    </div>

                    {{-- Jam Mulai --}}
                    <div class="mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <input type="text" class="form-control" value="{{ $jadwal->jam_mulai }}" disabled>
                    </div>

                    {{-- Jam Selesai --}}
                    <div class="mb-3">
                        <label class="form-label">Jam Selesai</label>
                        <input type="text" class="form-control" value="{{ $jadwal->jam_selesai }}" disabled>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" disabled>{{ $jadwal->ket }}</textarea>
                    </div>

                    {{-- Tombol --}}
                    <div class="mt-4">
                        <a href="{{ route('backend.jadwal.index') }}" class="btn btn-outline-warning">Kembali</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
