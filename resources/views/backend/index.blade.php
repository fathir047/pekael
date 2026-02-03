@extends('layouts.backend')

@section('content')
<div class="container-fluid">

  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <h3 class="fw-bold">Dashboard</h3>
      <p class="text-muted">Ringkasan data sistem booking ruangan</p>
    </div>
  </div>

  <!-- Statistik -->
  <div class="row g-4">

    <!-- User -->
    <div class="col-md-3">
      <div class="card shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="ti ti-user text-primary" style="font-size:64px;"></i>
          <h6 class="text-muted">User</h6>
          <h2 class="fw-bold">{{ \App\Models\User::count() }}</h2>
          <a href="{{ route('backend.user.index') }}" class="btn btn-sm btn-outline-primary mt-2">
            Detail
          </a>
        </div>
      </div>
    </div>

    <!-- Ruangan -->
    <div class="col-md-3">
      <div class="card shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="ti ti-door text-success" style="font-size:64px;"></i>
          <h6 class="text-muted">Ruangan</h6>
          <h2 class="fw-bold">{{ \App\Models\ruangans::count() }}</h2>
          <a href="{{ route('backend.ruangan.index') }}" class="btn btn-sm btn-outline-success mt-2">
            Detail
          </a>
        </div>
      </div>
    </div>

    <!-- Jadwal -->
    <div class="col-md-3">
      <div class="card shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="ti ti-calendar text-warning" style="font-size:64px;"></i>
          <h6 class="text-muted">Jadwal</h6>
          <h2 class="fw-bold">{{ \App\Models\jadwals::count() }}</h2>
          <a href="{{ route('backend.jadwal.index') }}" class="btn btn-sm btn-outline-warning mt-2">
            Detail
          </a>
        </div>
      </div>
    </div>

    <!-- Booking -->
    <div class="col-md-3">
      <div class="card shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="ti ti-bookmark text-danger" style="font-size:64px;"></i>
          <h6 class="text-muted">Booking</h6>
          <h2 class="fw-bold">{{ \App\Models\bookings::count() }}</h2>
          <a href="{{ route('backend.bookings.index') }}" class="btn btn-sm btn-outline-danger mt-2">
            Detail
          </a>
        </div>
      </div>
    </div>

  </div>

  <!-- Table Booking -->
  <div class="row mt-5">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header bg-white">
          <h5 class="fw-semibold mb-0">Booking Terbaru</h5>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>Nama</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach (\App\Models\bookings::latest()->limit(5)->get() as $b)
              <tr>
                <td>{{ $b->user->name ?? '-' }}</td>
                <td>{{ $b->ruangan->nama ?? '-' }}</td>
                <td>{{ $b->tanggal }}</td>
                <td>{{ $b->jam_mulai }} - {{ $b->jam_selesai }}</td>
                <td>
                    @switch($b->status)
                        @case('Pending')
                            <span class="badge bg-light text-dark">Menunggu</span>
                            @break
                        @case('Diterima')
                            <span class="badge bg-primary">Disetujui</span>
                            @break
                        @case('Ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                            @break
                        @case('Selesai')
                            <span class="badge bg-success">Selesai</span>
                            @break
                        @default
                            <span class="badge bg-warning">Tidak Diketahui</span>
                    @endswitch
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
