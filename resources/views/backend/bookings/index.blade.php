@extends('layouts.backend')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">

        {{-- Header --}}
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <h5 class="mb-0">Data Booking</h5>
            <div class="d-flex gap-2 ms-auto">
                <a href="{{ route('backend.bookings.export', [
                    'ruang_id' => request('ruang_id'),
                    'tanggal' => request('tanggal'),
                    'status' => request('status'),
                ]) }}" class="btn btn-sm btn-danger">
                    <i class="fa fa-file-pdf me-1"></i> Export PDF
                </a>

                <a href="{{ route('backend.bookings.create') }}"
                   class="btn btn-sm btn-light text-primary fw-semibold">
                    <i class="ti ti-plus me-1"></i> Tambah Booking
                </a>
            </div>
        </div>

        {{-- Filter --}}
        <div class="px-3 py-3">
            <form method="GET" action="{{ route('backend.bookings.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <select name="ruang_id" class="form-select">
                            <option value="">Pilih Ruangan</option>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}"
                                    {{ request('ruang_id') == $ruangan->id ? 'selected' : '' }}>
                                    {{ $ruangan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <input type="date" name="tanggal" class="form-control"
                               value="{{ request('tanggal') }}">
                    </div>

                    <div class="col-md-3 mb-2">
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <button type="submit" class="btn btn-outline-primary">Terapkan</button>
                        <a href="{{ route('backend.bookings.index') }}"
                           class="btn btn-outline-danger ms-2">
                           Tampilkan Semua
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Flash Message --}}
        <div class="px-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        {{-- Table --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="bookingTable">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Status</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $booking->user->name }}</td>
                            <td class="text-center">{{ $booking->ruangan->nama }}</td>
                            <td class="text-center">{{ $booking->tanggal_format }}</td>
                            <td class="text-center">{{ $booking->jam_mulai }}</td>
                            <td class="text-center">{{ $booking->jam_selesai }}</td>

                            {{-- Update Status Langsung --}}
                            <td class="text-center">
                                <form action="{{ route('backend.bookings.update-status', $booking->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')

                                    <select name="status"
                                            class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                        <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="Diterima" {{ $booking->status == 'Diterima' ? 'selected' : '' }}>
                                            Diterima
                                        </option>
                                        <option value="Ditolak" {{ $booking->status == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                        <option value="Selesai" {{ $booking->status == 'Selesai' ? 'selected' : '' }}>
                                            Selesai
                                        </option>
                                    </select>
                                </form>
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle"
                                            type="button"
                                            data-bs-toggle="dropdown">
                                        <i class="ti ti-dots"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('backend.bookings.show', $booking->id) }}"
                                               class="dropdown-item">
                                                <i class="ti ti-search me-1"></i> Detail
                                            </a>
                                        </li>

                                        <li>
                                            <form action="{{ route('backend.bookings.destroy', $booking->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger">
                                                    <i class="ti ti-trash me-1"></i> Hapus
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
        $('#bookingTable').DataTable();
    });
</script>
@endpush
