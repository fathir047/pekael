@extends('layouts.backend')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Jadwal Tetap</h4>
            <a href="{{ route('backend.jadwal.create') }}" class="btn btn-sm btn-light text-primary fw-semibold">Tambah Data</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="jadwalTable">
                    <thead class="table-head">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Ruangan</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jam Mulai</th>
                            <th class="text-center">Jam Selesai</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwals as $jadwal)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $jadwal->ruangan->nama }}</td>
                            <td class="text-center">{{ $jadwal->tanggal_format }}</td>
                            <td class="text-center">{{ $jadwal->jam_mulai }}</td>
                            <td class="text-center">{{ $jadwal->jam_selesai }}</td>
                            <td class="text-center">{{ $jadwal->ket }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="dropdown-toggle form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('backend.jadwal.show', $jadwal->id) }}" class="dropdown-item">
                                                <i class="ti ti-search me-1"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('backend.jadwal.edit', $jadwal->id) }}" class="dropdown-item">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('backend.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Delete this schedule?')">
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
        $('#jadwalTable').DataTable();
    });
</script>
@endpush
