@extends('layouts.frontend')

@section('content')

<div class="main-wrapper" style="padding-top: 100px;">
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 text-center text-lg-start">
          <h1 class="fw-bold text-primary">SIRUANG</h1>
          <p class="text-muted fs-5 mb-4">
            Sistem Penjadwalan Ruangan Kelas dan Laboratorium. Digital, efisien, dan bebas bentrok jadwal.
          </p>
          <a href="{{ route('bookings.create') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill">Booking Sekarang</a>
        </div>
        <div class="col-lg-6 text-center">
          <img src="{{ asset('assets/backend/img/KELAS.jpg') }}" alt="Ilustrasi Ruangan" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
        </div>
      </div>
    </div>
  </section>
  <section class="py-5">
    <div class="container">
      <div class="card border-0 shadow rounded-4">
        <div class="card-body">
          <h4 class="fw-semibold text-center mb-4">Kalender Jadwal & Booking</h4> 
          <table border="0" cellpadding="10">
            <tr>
              <td>
                <div style="display: flex; align-items: center;">
                  <div style="width: 20px; height: 20px; border-radius: 50px; background-color: #ff9500ff; margin-right: 10px;"></div>
                  <span>Di Booking</span>
                </div>
              </td>
              <td>
                <div style="display: flex; align-items: center;">
                  <div style="width: 20px; height: 20px; border-radius: 50px; background-color: #00aaffff; margin-right: 10px;"></div>
                  <span>Jadwal Tetap</span>
                </div>
              </td>
              <td>
                <div style="display: flex; align-items: center;">
                  <div style="width: 20px; height: 20px; border-radius: 50px; background-color: #fffb7dff; margin-right: 10px;"></div>
                  <span>Hari Ini</span>
                </div>
              </td>
            </tr>
          </table>

          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </section>
</div>

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
      eventColor: '#3A87AD',
      eventDisplay: 'block',
      eventTextColor: '#fff'
    });
    calendar.render();
  });
</script>

@endsection