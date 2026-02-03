@extends('layouts.frontend')

@section('content')

<div class="main-wrapper">
    {{-- HERO SECTION --}}
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="hero-title">RUANGIN</h1>
                    <p class="hero-desc">
                        Sistem Penjadwalan Ruangan Kelas dan Laboratorium.
                        Digital, efisien, dan bebas bentrok jadwal.
                    </p>
                    <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                        📅 Booking Sekarang
                    </a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/backend/img/KELAS.jpg') }}"
                        alt="Ilustrasi Ruangan"
                        class="hero-image">
                </div>
            </div>
        </div>
    </section>

    {{-- KALENDER --}}
    <section class="calendar-section">
        <div class="container">
            <div class="card calendar-card">
                <div class="card-body p-4">

                    <h4 class="text-center fw-semibold mb-4">
                        📆 Kalender Jadwal & Booking
                    </h4>

                    {{-- LEGEND --}}
                    <div class="legend-wrapper">
                        <div class="legend-item">
                            <span class="legend-dot booking"></span> Di Booking
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot tetap"></span> Jadwal Tetap
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot today"></span> Hari Ini
                        </div>
                    </div>

                    <div id="calendar"></div>

                </div>
            </div>
        </div>
    </section>
</div>

{{-- ================= CSS ================= --}}
<style>
.main-wrapper {
    padding-top: 100px;
    background: #f8f9fa;
}

/* HERO */
.hero-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f0f6ff, #ffffff);
}

.hero-title {
    font-size: 48px;
    font-weight: 800;
    color: #0d6efd;
}

.hero-desc {
    font-size: 18px;
    color: #6c757d;
    margin-bottom: 30px;
}

.hero-image {
    max-height: 320px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,.1);
}

/* KALENDER */
.calendar-section {
    padding: 60px 0;
}

.calendar-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
}

/* LEGEND */
.legend-wrapper {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.legend-dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
}

.legend-dot.booking {
    background: #ff9500;
}

.legend-dot.tetap {
    background: #00aaff;
}

.legend-dot.today {
    background: #fffb7d;
    border: 1px solid #ddd;
}

/* FULLCALENDAR */
.fc {
    font-size: 14px;
}

.fc-toolbar-title {
    font-weight: 700;
}

.fc-daygrid-event {
    border-radius: 8px;
    padding: 2px 4px;
}
</style>

{{-- ================= FULLCALENDAR ================= --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 'auto',
        aspectRatio: 1.6,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        events: @json($jadwal),
        eventDisplay: 'block',
        eventTextColor: '#fff'
    });

    calendar.render();
});
</script>

@endsection
