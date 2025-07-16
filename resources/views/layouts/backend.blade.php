<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/backend/images/logos/favicon.png')}}" />

  <!-- Core Css -->
  <link rel="stylesheet" href="{{ asset('assets/backend/css/styles.css')}}" />

  <title>Admin</title>
  <!-- Owl Carousel  -->
  <link rel="stylesheet" href="{{ asset('assets/backend/libs/owl.carousel/dist/assets/owl.carousel.min.css')}}" />
</head>

<body>
 
  <!-- Preloader -->
  <div class="preloader">
      <img src="{{ asset('/assets/backend/img/dark-logo.png')}}" alt="loader" class="lds-ripple img-fluid" style="width:200px" />
  </div>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
            @include ('layouts.components-backend.sidebar')
    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
            @include    ('layouts.components-backend.navbar')
      <!--  Header End --> 

      <div class="body-wrapper">
         @yield('content')
      </div>
      <script>
        function handleColorTheme(e) {
          document.documentElement.setAttribute("data-color-theme", e);
        }
      </script>
    </div>
  </div>
  <script src="{{ asset('assets/backend/js/vendor.min.js')}}"></script>
  <!-- Import Js Files -->
  <script src="{{ asset('assets/backend/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/backend/libs/simplebar/dist/simplebar.min.js')}}"></script>
  <script src="{{ asset('assets/backend/js/theme/app.init.js')}}"></script>
  <script src="{{ asset('assets/backend/js/theme/theme.js')}}"></script>
  <script src="{{ asset('assets/backend/js/theme/app.min.js')}}"></script>
  <script src="{{ asset('assets/backend/js/theme/sidebarmenu.js')}}"></script>

  <!-- solar icons -->
  <script src="https://cdn.js')}}delivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js')}}"></script>
  <script src="{{ asset('assets/backend/libs/owl.carousel/dist/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('assets/backend/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
  <script src="{{ asset('assets/backend/js/dashboards/dashboard.js')}}"></script>

  @include('sweetalert::alert')
  @stack('scripts') 
  @yield('js')
</body>

</html>