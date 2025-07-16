<aside class="left-sidebar with-vertical">
    <div>
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="/main/index.html" class="text-nowrap logo-img">
            <img src="/assets/backend/img/dark-logo.png" class="dark-logo" height="53px" alt="Logo-Dark" />
            <img src="/assets/backend/img/light-logo.png" class="light-logo"  height="70px" alt="Logo-light" style="margin-left: 5px;"/>
          </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div> 

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <hr>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('admin') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('backend.user.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">User</span>
                    </a>
                </li>
                <li class="sidebar-item">       
                    <a class="sidebar-link" href="{{ route('backend.ruangan.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-door"></i>
                        </span>
                        <span class="hide-menu">Ruangan</span>
                    </a>
                </li>
                  <li class="sidebar-item">       
                    <a class="sidebar-link" href="{{ route('backend.jadwal.index') }}" aria-expanded="false">
                       <span>
                            <i class="ti ti-calendar"></i>
                        </span>
                        <span class="hide-menu">Jadwal</span>
                    </a>
                </li>
                  <li class="sidebar-item">       
                    <a class="sidebar-link" href="{{ route('backend.bookings.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-bookmark"></i>
                        </span>
                        <span class="hide-menu">Booking</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                    <img src="{{asset('/assets/backend/img/pp.jpeg')}}" class="rounded-circle" width="40" height="40" alt="modernize-img" />
                </div>
                <div class="john-title">
                    <h6 class="mb-0 fs-4 fw-semibold">{{Auth::user()->name}}</h6>
                    <span class="fs-2">{{Auth::user()->is_admin == 1 ? 'admin': ''}}</span>
                </div>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                    <i class="ti ti-power fs-6"></i>
                </a>
                <form action="{{ route('logout') }}" method="post" id="logout-form">
                    @csrf
                </form>
            </div>
        </div>

        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
    </div>
</aside>