@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <b>Edit Ruangan</b>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.ruangan.update', $ruangan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Ruangan</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ $ruangan->nama }}" required>
                        </div>

                        {{-- Kapasitas --}}
                        <div class="mb-3">
                            <label for="kapasitas" class="form-label">Kapasitas</label>
                            <input type="text" name="kapasitas" id="kapasitas" class="form-control" value="{{ $ruangan->kapasitas }}" required>
                        </div>
 
                        {{-- Fasilitas --}}
                        <div class="mb-3">
                            <label for="fasilitas" class="form-label">Fasilitas</label>
                            <textarea name="fasilitas" id="fasilitas" class="form-control" rows="4" required>{{ $ruangan->fasilitas }}</textarea>
                        </div>

                        {{-- Cover --}}
                        <div class="mb-3">
                            @if($ruangan->cover)
                            <br>
                                <img src="{{ asset('storage/' . $ruangan->cover) }}" alt="Current Cover" width="200" class="img-thumbnail">
                            <br><br>
                            @endif
                            <label for="cover" class="form-label">Ganti Foto</label>
                            <input type="file" name="cover" id="cover" class="form-control">
                        </div>

                        {{-- Tombol --}}
                        <div class="mt-4">
                            <button type="submit" class="btn btn-outline-primary">Update</button>
                            <a href="{{ route('backend.ruangan.index') }}" class="btn btn-outline-warning ms-2">Batal</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
