@extends('layouts.backend')
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Ruangan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.ruangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Cover</label>
                    <input type="file" name="cover" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Ruangan</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fasilitas</label>
                    <textarea name="fasilitas" rows="4" class="form-control" required></textarea>
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-sm btn-outline-primary me-2">Save</button>
                    <a href="{{ route('backend.ruangan.index') }}" class="btn btn-sm btn-outline-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div> 
@endsection
