<body class="tv-magic-cursor">
    <div class="main-overlay"></div>
    <!-- Preloader -->
    <div id="preloader">
       <div class="preloader">
          <span></span>
          <span></span>
       </div>
    </div>

    <!-- Header Start -->
    <header class="header header-transparent">
       <div class="header-wrapper">
          <div class="sticky-height"></div>
          <!-- Navigation Menu Start -->
          <div class="header-nav-wrapper header-sticky">
             <nav class="navbar navbar-expand-xl">
                <div class="container-fluid mx-lg-5">
                   <a href="index-2.html" class="navbar-brand">
                      <img src="assets/images/logo-w.svg" alt="logo" class="img-fluid">
                   </a>
                   <button class="navbar-toggler offcanvas-nav-btn text-white" type="button">
                      Menu <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" fill="none"
                         viewBox="0 0 14 12">
                         <path fill="#fff"
                            d="M0 .75Q.063.063.75 0h12.5q.687.063.75.75-.063.687-.75.75H.75Q.063 1.437 0 .75m0 5Q.063 5.063.75 5h12.5q.687.063.75.75-.063.687-.75.75H.75Q.063 6.437 0 5.75m13.25 5.75H.75q-.687-.063-.75-.75.063-.687.75-.75h12.5q.687.063.75.75-.063.687-.75.75" />
                      </svg>
                   </button>
                   <div class="nav-cta d-none d-md-flex order-lg-3">
                      <div class="d-flex align-items-center justify-content-between gap-3">
                         <a href="#" class="icon-lg text-info" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvas-search"><i class="fa fa-search"></i></a>
                        @auth
                            <a href="{{ route('profiles.show', auth()->user()->researchProfile->id) }}" name="submit" class="btn btn-border">My Profile</a>
                        @endauth
                        @if (auth()->user())
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" name="submit" class="btn btn-border">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-border">Login</a>
                        @endif
                      </div>
                   </div>
                   <div class="offcanvas offcanvas-start offcanvas-nav">
                      <div class="offcanvas-header">
                         <a href="{{ url('/') }}" class="text-inverse"><img src="assets/images/logo.svg" alt="Logo"></a>
                         <button type="button" class="btn-close bg-primary" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                      </div>

                      <div class="offcanvas-body pt-0 align-items-center justify-content-between">
                         <ul class="navbar-nav mx-auto align-items-lg-center">
                            <li class="nav-item dropdown">
                               <a class="nav-link" href="{{ route('profiles.index') }}">Researchers</a>
                            </li>
                         </ul>
                      </div>
                   </div>
                </div>
             </nav>
          </div>
       </div>
    </header>
    <!-- Header End -->
