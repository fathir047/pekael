<style>
  .navbar-wrapper {
    margin-top: 1rem; /* Atur jarak dari atas */
    padding: 0 1rem;
    z-index: 1030;
  }

  .navbar-custom {
    border-radius: 50px; /* Oval */
    padding: 0.5rem 1rem;
    background-color: #ffffff; /* putih */
  }
</style>

<div class="position-fixed top-0 start-0 end-0 navbar-wrapper">
  <nav class="navbar navbar-expand-lg shadow navbar-custom">
    <div class="container-fluid">

      <!-- Logo -->
      <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
        <img src="{{ asset('assets/backend/img/navuser.png') }}" alt="Logo" style="height: 40px;">
      </a>

      <!-- Toggle Button (Mobile) -->
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Items -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mx-auto gap-lg-4">
          <li class="nav-item">
            <a class="nav-link text-dark fw-medium" href="{{ url('/') }}">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark fw-medium" href="{{ route('bookings.create') }}">Booking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark fw-medium" href="{{ route('ruangan.show') }}">Ruangan</a>
          </li>
          @auth
          <li class="nav-item">
            <a class="nav-link text-dark fw-medium" href="{{ route('bookings.riwayat') }}">Riwayat</a>
          </li>
          @endauth
        </ul>

        <!-- Auth -->
        <ul class="navbar-nav ms-auto">
          @guest
            <li class="nav-item">
              <a class="btn btn-primary rounded-pill px-5 py-3" href="{{ route('login') }}">Login</a>
            </li>
          @else
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end"> 
                <li>
                  <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>
              </ul>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>
</div>
