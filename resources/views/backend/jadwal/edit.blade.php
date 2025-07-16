@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Jadwal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Ruangan --}}
                        <div class="mb-3">
                            <label class="form-label">Ruangan</label>
                            <select name="ruang_id" class="form-control" required>
                                <option value="">Pilih Ruangan</option>
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}" {{ $ruangan->id == $jadwal->ruang_id ? 'selected' : '' }}>
                                        {{ $ruangan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
 
                        <!-- tanggal -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $jadwal->tanggal }}" required>
                        </div>

                        <!-- Jam mulai -->
                        <div class="mb-3">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" value="{{ $jadwal->jam_mulai }}" required>
                        </div>

                        <!-- jam selesai -->
                        <div class="mb-3">
                            <label class="form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" value="{{ $jadwal->jam_selesai }}" required>
                        </div>

                        <!-- keterangan -->
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="ket" class="form-control" value="{{ $jadwal->ket }}" required>
                        </div>

                        <!-- tombol -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-outline-primary">Update</button>
                            <a href="{{ route('backend.jadwal.index') }}" class="btn btn-outline-danger ms-2">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
