@extends('layouts.frontend')

@section('content')
<div class="container booking-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card booking-card">
                <div class="card-body p-5">

                    <h4 class="booking-title">
                        📅 Form Booking Ruangan
                    </h4>

                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ruangan</label>
                            <select name="ruang_id" class="form-select form-select-lg" required>
                                <option disabled selected>-- Pilih Ruangan --</option>
                                @foreach ($ruangans as $data    )
                                    <option value="{{ $data->id }}"
                                        {{ request('ruang_id') == $data->id || old('ruang_id') == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal"
                                    class="form-control form-control-lg" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai"
                                    class="form-control form-control-lg" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai"
                                    class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-primary btn-lg fw-semibold">
                                🚀 Ajukan Booking
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>



{{-- CSS --}}
<style>
.booking-wrapper {
    padding-top: 240px;
    padding-bottom: 60px;
}

.booking-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
    animation: fadeIn .4s ease-in-out;
}

.booking-title {
    font-weight: 700;
    text-align: center;
    margin-bottom: 30px;
}

.form-control,
.form-select {
    border-radius: 12px;
}

.form-control:focus,
.form-select:focus {
    box-shadow: 0 0 0 .15rem rgba(13,110,253,.25);
}

.btn-primary {
    border-radius: 14px;
    padding: 12px;
}

.is-invalid {
    border-color: #dc3545;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tanggalInput = document.getElementById('tanggal');
    const jamMulaiInput = document.getElementById('jam_mulai');
    const jamSelesaiInput = document.getElementById('jam_selesai');

    function pad(n) {
        return n < 10 ? '0' + n : n;
    }

    function getCurrentTime() {
        const now = new Date();
        return pad(now.getHours()) + ':' + pad(now.getMinutes());
    }

    tanggalInput.addEventListener('change', function () {
        const selectedDate = new Date(this.value);
        const today = new Date();

        jamMulaiInput.classList.remove('is-invalid');
        jamSelesaiInput.classList.remove('is-invalid');

        if (selectedDate.toDateString() === today.toDateString()) {
            const currentTime = getCurrentTime();

            jamMulaiInput.setAttribute('min', currentTime);
            jamSelesaiInput.setAttribute('min', currentTime);

            jamMulaiInput.addEventListener('input', () => {
                jamMulaiInput.classList.toggle('is-invalid', jamMulaiInput.value < currentTime);
            });

            jamSelesaiInput.addEventListener('input', () => {
                jamSelesaiInput.classList.toggle('is-invalid', jamSelesaiInput.value < currentTime);
            });
        } else {
            jamMulaiInput.removeAttribute('min');
            jamSelesaiInput.removeAttribute('min');
        }
    });
});
</script>
@endsection
