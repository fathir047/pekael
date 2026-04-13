{{-- NAVBAR RESPONSIVE --}}
<style>
    :root {
        --primary: #0d6efd;
        --dark: #212529;
        --light: #ffffff;
        --border-color: #dee2e6;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 8px 16px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .navbar-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        margin-top: 0;
        padding: clamp(8px, 1.5vw, 12px) clamp(12px, 2vw, 24px);
        z-index: 1030;
        background: transparent;
    }

    .navbar-custom {
        border-radius: clamp(20px, 5vw, 50px);
        padding: clamp(6px, 1.5vw, 10px) clamp(12px, 2vw, 24px);
        background-color: var(--light);
        box-shadow: var(--shadow-sm);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: var(--transition);
    }

    .navbar-custom:hover {
        box-shadow: var(--shadow-md);
    }

    .navbar-brand {
        font-weight: 700;
        color: var(--primary) !important;
        text-decoration: none;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: clamp(8px, 1.5vw, 12px);
    }

    .navbar-brand:hover {
        transform: scale(1.05);
    }

    .navbar-brand img {
        height: clamp(30px, 6vw, 40px);
        width: auto;
        transition: var(--transition);
    }

    .navbar-brand:hover img {
        filter: brightness(1.1);
    }

    /* ============= NAVBAR ITEMS ============= */
    .navbar-nav {
        gap: clamp(12px, 2vw, 32px);
    }

    .nav-item {
        position: relative;
    }

    .nav-link {
        color: var(--dark) !important;
        font-weight: 500;
        font-size: clamp(12px, 2vw, 14px);
        padding: clamp(6px, 1.2vw, 8px) 0;
        transition: var(--transition);
        position: relative;
        text-decoration: none;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: var(--primary);
        transition: var(--transition);
    }

    .nav-link:hover {
        color: var(--primary) !important;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .nav-link.active {
        color: var(--primary) !important;
        font-weight: 700;
    }

    .nav-link.active::after {
        width: 100%;
    }

    /* ============= DROPDOWN ============= */
    .dropdown-toggle::after {
        display: none;
    }

    .dropdown-toggle {
        padding-right: 16px;
    }

    .dropdown-toggle::before {
        content: '';
        position: absolute;
        right: 0;
        width: 0;
        height: 0;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 5px solid currentColor;
        transition: var(--transition);
    }

    .dropdown-toggle[aria-expanded="true"]::before {
        transform: rotate(180deg);
    }

    .dropdown-menu {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: var(--shadow-md);
        padding: clamp(8px, 1.5vw, 12px) 0;
        margin-top: clamp(8px, 1.5vw, 12px);
    }

    .dropdown-item {
        padding: clamp(8px, 1.5vw, 10px) clamp(12px, 2vw, 16px);
        font-size: clamp(12px, 1.8vw, 14px);
        color: var(--dark);
        transition: var(--transition);
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: var(--primary);
    }

    .dropdown-item.text-danger:hover {
        background-color: #ffe6e6;
    }

    /* ============= AUTH BUTTONS ============= */
    .btn {
        font-size: clamp(12px, 2vw, 14px);
        padding: clamp(8px 16px, 1.2vw 2vw, 10px 24px);
        border-radius: clamp(8px, 2vw, 50px);
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        font-weight: 500;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0a58ca;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(13, 110, 253, 0.3);
    }

    /* ============= NAVBAR TOGGLER ============= */
    .navbar-toggler {
        border: none;
        padding: clamp(6px, 1.5vw, 8px) !important;
        transition: var(--transition);
    }

    .navbar-toggler:focus {
        box-shadow: none;
        outline: 2px solid var(--primary);
    }

    .navbar-toggler-icon {
        width: clamp(20px, 4vw, 24px);
        height: clamp(20px, 4vw, 24px);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23212529' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
    }

    /* ============= NAVBAR COLLAPSE ============= */
    .navbar-collapse {
        transition: var(--transition);
    }

    .navbar-collapse.show {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ============= RESPONSIVE BREAKPOINTS ============= */
    @media (max-width: 992px) {
        .navbar-wrapper {
            padding: clamp(6px, 1.2vw, 10px) clamp(10px, 1.5vw, 16px);
        }

        .navbar-custom {
            padding: clamp(4px, 1vw, 8px) clamp(10px, 1.5vw, 16px);
        }

        /* Mobile Menu */
        .collapse.navbar-collapse {
            position: absolute;
            top: 100%;
            left: clamp(10px, 2vw, 20px);
            right: clamp(10px, 2vw, 20px);
            background: var(--light);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            padding: clamp(12px, 2vw, 16px);
            margin-top: clamp(8px, 1.5vw, 12px);
            flex-direction: column;
        }

        .navbar-nav {
            flex-direction: column;
            gap: 0;
            width: 100%;
        }

        .navbar-nav.mx-auto {
            margin-left: 0 !important;
            margin-right: 0 !important;
            margin-bottom: clamp(12px, 2vw, 16px);
        }

        .nav-item {
            width: 100%;
        }

        .nav-link {
            padding: clamp(8px, 1.5vw, 10px) 0;
            display: block;
            font-weight: 500;
        }

        .nav-link::after {
            display: none;
        }

        .nav-link.active {
            color: var(--primary) !important;
            padding-left: 8px;
            border-left: 3px solid var(--primary);
        }

        /* Mobile Auth */
        .navbar-nav.ms-auto {
            margin-left: 0 !important;
            margin-top: clamp(12px, 2vw, 16px);
            padding-top: clamp(12px, 2vw, 16px);
            border-top: 1px solid var(--border-color);
        }

        .nav-item.dropdown {
            width: 100%;
        }

        .dropdown-toggle {
            padding-right: 0;
            position: relative;
        }

        .dropdown-toggle::before {
            display: none;
        }

        .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.5em;
        }

        .btn {
            width: 100%;
            justify-content: center;
            margin-top: clamp(8px, 1.5vw, 12px);
        }

        .d-grid {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .navbar-wrapper {
            padding: 6px 8px;
        }

        .navbar-custom {
            padding: 4px 8px;
            border-radius: 25px;
        }

        .navbar-brand {
            gap: 6px;
        }

        .navbar-brand img {
            height: 28px;
        }

        .collapse.navbar-collapse {
            left: 6px;
            right: 6px;
            padding: 10px 12px;
        }

        .nav-link {
            font-size: 13px;
            padding: 6px 0;
        }

        .btn {
            font-size: 12px;
            padding: 8px 14px;
        }

        .dropdown-item {
            padding: 6px 12px;
            font-size: 13px;
        }
    }

    @media (max-width: 380px) {
        .navbar-wrapper {
            padding: 4px 6px;
        }

        .navbar-custom {
            padding: 3px 6px;
        }

        .navbar-brand {
            gap: 4px;
        }

        .navbar-brand img {
            height: 24px;
        }

        .collapse.navbar-collapse {
            left: 4px;
            right: 4px;
            padding: 8px;
        }

        .nav-link {
            font-size: 12px;
        }

        .btn {
            font-size: 11px;
            padding: 6px 12px;
        }
    }

    /* ============= ANIMATIONS ============= */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div class="position-fixed top-0 start-0 end-0 navbar-wrapper">
    <nav class="navbar navbar-expand-lg shadow navbar-custom">
        <div class="container-fluid" style="max-width: 100%; padding: 0;">

      <!-- Logo -->
      <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
        <img src="{{ asset('assets/backend/img/nav_user.png') }}" alt="Logo" style="height: 40px;">
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
