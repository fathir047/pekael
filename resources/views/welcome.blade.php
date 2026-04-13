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
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    .main-wrapper {
        padding-top: 100px;
        background: #f8f9fa;
    }

    /* ============= HERO SECTION ============= */
    .hero-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f0f6ff, #ffffff);
    }

    .hero-title {
        font-size: clamp(32px, 8vw, 48px);
        font-weight: 800;
        color: #0d6efd;
        margin-bottom: 20px;
    }

    .hero-desc {
        font-size: clamp(14px, 2.5vw, 18px);
        color: #6c757d;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .hero-image {
        max-height: 320px;
        width: 100%;
        height: auto;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        display: inline-block;
        font-size: clamp(13px, 2vw, 16px);
        padding: clamp(10px 20px, 2vw 3vw, 14px 28px);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3);
    }

    /* ============= KALENDER SECTION ============= */
    .calendar-section {
        padding: 60px 0;
    }

    .calendar-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .calendar-card .card-body {
        padding: clamp(20px, 4vw, 40px);
    }

    .calendar-card h4 {
        font-size: clamp(16px, 3vw, 20px);
        margin-bottom: clamp(20px, 4vw, 30px);
    }

    /* ============= LEGEND ============= */
    .legend-wrapper {
        display: flex;
        justify-content: center;
        gap: clamp(15px, 3vw, 30px);
        margin-bottom: clamp(15px, 3vw, 25px);
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        font-size: clamp(12px, 2vw, 15px);
    }

    .legend-dot {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        flex-shrink: 0;
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

    /* ============= FULLCALENDAR ============= */
    .fc {
        font-size: clamp(11px, 1.5vw, 14px);
    }

    .fc-toolbar {
        flex-direction: row;
        flex-wrap: wrap;
        gap: clamp(8px, 2vw, 15px);
        margin-bottom: clamp(15px, 3vw, 25px);
    }

    .fc-toolbar-title {
        font-weight: 700;
        font-size: clamp(16px, 3vw, 24px);
        order: 2;
        flex: 1;
        min-width: 100%;
        margin: 0;
    }

    .fc-button-group {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .fc-button-primary {
        font-size: clamp(11px, 1.5vw, 13px);
        padding: clamp(5px 10px, 1vw 2vw, 8px 15px);
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .fc-button-primary:hover,
    .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #0a58ca;
        border-color: #0a58ca;
    }

    .fc-daygrid-event {
        border-radius: 8px;
        padding: 2px 4px;
        font-size: clamp(10px, 1.5vw, 12px);
    }

    .fc-daygrid-day-frame {
        min-height: clamp(70px, 12vw, 100px);
    }

    .fc-col-header-cell {
        padding: clamp(8px, 2vw, 12px);
        font-weight: 600;
        font-size: clamp(11px, 1.5vw, 13px);
    }

    .fc-daygrid-day {
        padding: clamp(4px, 1vw, 8px);
    }

    /* ============= RESPONSIVE LAYOUT ============= */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 clamp(16px, 3vw, 30px);
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: -12px;
    }

    .col-lg-6 {
        flex: 1;
        min-width: 0;
        padding: 12px;
    }

    .text-center {
        text-align: center;
    }

    .text-lg-start {
        text-align: inherit;
    }

    .align-items-center {
        align-items: center;
    }

    /* ============= MOBILE RESPONSIVE ============= */
    @media (max-width: 992px) {
        .hero-section {
            padding: 60px 0;
        }

        .col-lg-6 {
            flex: 0 0 100%;
        }

        .text-lg-start {
            text-align: center;
        }

        .hero-image {
            max-height: 280px;
            margin-top: 20px;
        }

        .hero-title {
            font-size: clamp(28px, 6vw, 40px);
        }

        .hero-desc {
            font-size: clamp(13px, 2vw, 16px);
        }
    }

    @media (max-width: 768px) {
        .main-wrapper {
            padding-top: 80px;
        }

        .hero-section {
            padding: 50px 0;
        }

        .calendar-section {
            padding: 40px 0;
        }

        .calendar-card .card-body {
            padding: clamp(15px, 3vw, 25px);
        }

        .btn-primary {
            width: 100%;
            text-align: center;
        }

        .legend-wrapper {
            gap: 12px;
        }

        .legend-item {
            font-size: clamp(11px, 1.8vw, 13px);
        }

        .fc-toolbar {
            justify-content: center;
        }

        .fc-toolbar-title {
            order: 1;
            min-width: auto;
            margin-bottom: 10px;
            flex: 0 0 100%;
        }

        .fc-button-group {
            order: 2;
            justify-content: center;
            width: 100%;
        }

        .fc-toolbar .fc-prev-button,
        .fc-toolbar .fc-next-button,
        .fc-toolbar .fc-today-button {
            font-size: clamp(10px, 1.5vw, 12px);
            padding: clamp(4px 8px, 1vw 1.5vw, 6px 12px);
        }

        .fc-daygrid-day-frame {
            min-height: clamp(60px, 10vw, 80px);
        }

        .fc-daygrid-event {
            font-size: clamp(9px, 1.2vw, 11px);
        }
    }

    @media (max-width: 576px) {
        .main-wrapper {
            padding-top: 60px;
        }

        .hero-section {
            padding: 40px 0;
        }

        .hero-title {
            font-size: clamp(24px, 5vw, 32px);
        }

        .hero-desc {
            font-size: clamp(12px, 1.8vw, 14px);
            margin-bottom: 20px;
        }

        .container {
            padding: 0 12px;
        }

        .row {
            margin: -8px;
        }

        .col-lg-6 {
            padding: 8px;
        }

        .hero-image {
            max-height: 240px;
            margin-top: 15px;
        }

        .calendar-section {
            padding: 30px 0;
        }

        .calendar-card .card-body {
            padding: 15px;
        }

        .calendar-card h4 {
            font-size: clamp(14px, 2.5vw, 16px);
            margin-bottom: 15px;
        }

        .legend-wrapper {
            gap: 10px;
            margin-bottom: 15px;
        }

        .legend-item {
            font-size: clamp(10px, 1.5vw, 12px);
        }

        .fc {
            font-size: clamp(10px, 1.3vw, 12px);
        }

        .fc-toolbar {
            gap: 6px;
            margin-bottom: 12px;
        }

        .fc-toolbar-title {
            font-size: clamp(14px, 2.5vw, 18px);
        }

        .fc-button-primary {
            font-size: clamp(9px, 1.2vw, 11px);
            padding: clamp(4px 6px, 0.8vw 1.2vw, 5px 10px);
        }

        .fc-col-header-cell {
            padding: clamp(6px, 1.5vw, 8px);
            font-size: clamp(10px, 1.3vw, 11px);
        }

        .fc-daygrid-day {
            padding: clamp(2px, 0.8vw, 4px);
        }

        .fc-daygrid-day-frame {
            min-height: clamp(50px, 8vw, 60px);
        }

        .fc-daygrid-event {
            font-size: clamp(8px, 1vw, 10px);
            padding: 1px 2px;
        }

        .btn-primary {
            font-size: clamp(12px, 1.8vw, 14px);
            padding: clamp(8px 16px, 1.5vw 2.5vw, 10px 20px);
        }
    }

    @media (max-width: 380px) {
        .container {
            padding: 0 10px;
        }

        .hero-title {
            font-size: 22px;
        }

        .fc-toolbar-title {
            font-size: 14px;
        }

        .fc-daygrid-day-frame {
            min-height: 45px;
        }
    }
</style>

<!-- FullCalendar CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<!-- FullCalendar Init Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'id',
      height: 'auto',
      contentHeight: 'auto',
      aspectRatio: 1.6,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,listMonth'
      },
      buttonText: {
        today: 'Hari Ini',
        month: 'Bulan',
        listMonth: 'List'
      },
      events: @json($jadwal),
      eventDisplay: 'block',
      eventTextColor: '#fff',
      eventDidMount: function (info) {
        if (info.event.extendedProps.description) {
          new bootstrap.Tooltip(info.el, {
            title: info.event.extendedProps.description,
            placement: 'top',
            trigger: 'hover',
            container: 'body',
            html: true,
          });
        }
      }
    });
    calendar.render();
  });
</script>

@endsection