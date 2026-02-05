@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Booking</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.bookings.store') }}" method="POST">
                @csrf

                <!-- PENGGUNA -->
                <div class="mb-3mb-3 row align-items-center">
                    <label class="form-label">Pengguna</label>
                    <select name="user_id" id="userSelect" class="form-select" required>
                        <option value="">Pilih Pengguna</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" data-email="{{ $user->email }}"
                                data-role="{{ $user->is_admin ? 'Admin' : 'User' }}">
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- EMAIL & ROLE -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" id="userEmail" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <input type="text" id="userRole" class="form-control" readonly>
                    </div>
                </div>

                <!-- RUANGAN -->
                <div class="mb-3">
                    <label class="form-label">Ruangan</label>
                    <select name="ruang_id" class="form-select" required>
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach ($ruangans as $ruangan)
                            <option value="{{ $ruangan->id }}">
                                {{ $ruangan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- TANGGAL -->
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <!-- JAM -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" required>
                    </div>
                </div>

                <button class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection


@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endpush


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(function () {

    $('#userSelect').select2({
        placeholder: '-- Pilih Pengguna --',
        allowClear: true,
        width: '100%'
    });

    $('#userSelect').on('select2:select', function (e) {
        const el = e.params.data.element;
        $('#userEmail').val($(el).data('email'));
        $('#userRole').val($(el).data('role'));
    });

    $('#userSelect').on('select2:clear', function () {
        $('#userEmail').val('');
        $('#userRole').val('');
    });

});
</script>
@endpush
