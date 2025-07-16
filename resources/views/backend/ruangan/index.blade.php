@extends('layouts.backend')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Ruangan</h4>
            <a href="{{ route('backend.ruangan.create') }}" class="btn btn-sm btn-light text-primary fw-semibold">Tambah Data</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="ruanganTable">
                    <thead class="table-head">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Cover</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Kapasitas</th>
                            <th class="text-center">Fasilitas</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ruangans as $ruangan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center"><img src="{{ asset('storage/'.$ruangan->cover) }}" alt="cover" width="100%"></td>
                            <td class="text-center">{{ $ruangan->nama }}</td>
                            <td class="text-center">{{ $ruangan->kapasitas }}</td>
                            <td class="text-center">{{Str::limit( $ruangan->fasilitas, 20 )}}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="dropdown-toggle form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('backend.ruangan.show', $ruangan->id) }}" class="dropdown-item">
                                                <i class="ti ti-search me-1"></i> View
                                            </a>
                                        </li> 
                                        <li>
                                            <a href="{{ route('backend.ruangan.edit', $ruangan->id) }}" class="dropdown-item">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('backend.ruangan.destroy', $ruangan->id) }}" method="POST" onsubmit="return confirm('Delete this room?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">
                                                    <i class="ti ti-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function () {
        $('#ruanganTable').DataTable();
    });
</script>
@endpush
