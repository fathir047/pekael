@extends('layouts.frontend')

@section('content')
<div class="container booking-wrapper">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-7">

            <div class="card booking-card">
                <div class="card-body p-3 p-sm-4 p-md-5">

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
                                @foreach ($ruangans as $data)
                                    <option value="{{ $data->id }}"
                                        {{ request('ruang_id') == $data->id || old('ruang_id') == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-2 g-md-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal"
                                    class="form-control form-control-lg" required>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai"
                                    class="form-control form-control-lg" required>
                            </div>

                            <div class="col-12 col-md-4">
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
        padding-top: clamp(60px, 15vw, 240px);
        padding-bottom: clamp(40px, 8vw, 60px);
        padding-left: clamp(12px, 3vw, 20px);
        padding-right: clamp(12px, 3vw, 20px);
    }

    .booking-card {
        border: none;
        border-radius: clamp(12px, 3vw, 20px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        animation: fadeIn 0.4s ease-in-out;
    }

    .booking-card .card-body {
        border-radius: clamp(12px, 3vw, 20px);
    }

    .booking-title {
        font-weight: 700;
        text-align: center;
        margin-bottom: clamp(20px, 5vw, 30px);
        font-size: clamp(18px, 4vw, 24px);
    }

    .form-label {
        font-size: clamp(13px, 2vw, 15px);
        margin-bottom: clamp(6px, 1vw, 8px);
    }

    .form-control,
    .form-select {
        border-radius: clamp(8px, 2vw, 12px);
        font-size: clamp(13px, 2vw, 15px);
        padding: clamp(8px 12px, 1.5vw 2vw, 12px 16px);
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
        border-color: #0d6efd;
    }

    .form-select-lg,
    .form-control-lg {
        font-size: clamp(13px, 2vw, 15px);
        padding: clamp(8px 12px, 1.5vw 2vw, 12px 16px);
    }

    .btn-primary {
        border-radius: clamp(10px, 2vw, 14px);
        padding: clamp(10px, 2vw, 12px);
        font-size: clamp(14px, 2.5vw, 16px);
    }

    .btn-lg {
        padding: clamp(10px, 2vw, 12px) !important;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3);
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .alert {
        font-size: clamp(13px, 2vw, 15px);
        padding: clamp(10px 12px, 2vw 3vw, 12px 16px);
        margin-bottom: clamp(15px, 3vw, 20px);
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

    /* MOBILE RESPONSIVE */
    @media (max-width: 576px) {
        .booking-wrapper {
            padding-top: clamp(50px, 10vw, 120px);
        }

        .row.g-2 {
            row-gap: 8px !important;
        }

        .btn-primary {
            margin-top: clamp(10px, 2vw, 15px);
        }
    }

    @media (max-width: 380px) {
        .booking-wrapper {
            padding-left: 8px;
            padding-right: 8px;
        }

        .booking-card .card-body {
            padding: 12px !important;
        }

        .form-label {
            font-size: 12px;
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