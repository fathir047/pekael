@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 100px;">
    <h2 class="mb-4 fw-bold text-center">Riwayat Booking Anda</h2>

    @if($booking->count())
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Ruangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->ruangan->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
                            <td>
                                @switch($data->status)
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
    @else
        <div class="alert alert-info text-center">
            Belum ada riwayat booking ruangan.
        </div>
    @endif
</div>
@endsection