<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{asset('assets/backend/images/logos/favicon.png')}}" />

  <!-- Core Css -->
  <link rel="stylesheet" href="{{asset('assets/backend/css/styles.css')}}" />

  <title>siruang</title>
  <!-- Owl Carousel  -->
  <link rel="stylesheet" href="{{asset('assets/backend/libs/owl.carousel/dist/assets/owl.carousel.min.css')}}" />
</head>

<body>


  <!-- Preloader -->
  <div class="preloader">
    <img src="{{asset ('assets/backend/img/dark-logo.png')}}" alt="loader" class="lds-ripple img-fluid" style="width:200px"  />
  </div>

  <!-- navbar -->
    @include('layouts.components-frontend.navbar')
  <!-- end navbar -->

 
  <main>
    @yield('content')
  </main>


  <!-- Scroll Top -->
  <a href="javascript:void(0)" class="top-btn btn btn-primary d-flex align-items-center justify-content-center round-54 p-0 rounded-circle">
    <i class="ti ti-arrow-up fs-7"></i>
  </a>

  <script src="{{asset('assets/backend/js/vendor.min.js')}}"></script>
  <!-- Import Js Files -->
  <script src="{{asset('assets/backend/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/backend/libs/simplebar/dist/simplebar.min.js')}}"></script>
  <script src="{{asset('assets/backend/js/theme/app.init.js')}}"></script>
  <script src="{{asset('assets/backend/js/theme/theme.js')}}"></script>
  <script src="{{asset('assets/backend/js/theme/app.min.js')}}"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js')}}"></script>
  <script src="{{asset('assets/backend/libs/owl.carousel/dist/owl.carousel.min.js')}}"></script>
  <script src="{{asset('assets/backend/js/frontend-landingpage/homepage.js')}}"></script>
  @include('sweetalert::alert')
  @stack('styles')
  @stack('scripts')
</body>

</html> 