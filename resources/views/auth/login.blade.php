@include('auth.partials.head')

@include('auth.partials.header')

   <!-- Promo Section Start -->
   <section class="promo-sec bg-cover jarallax" data-jarallax data-speed=".6">
      <img src="assets/images/promo-bg.jpg" alt="" class="jarallax-img">
      <div class="parallax-overly"></div>
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="promo-wrap position-relative">
                  <h1 class="display-1 text-info text-center">Login</h1>
                  <nav aria-label="breadcrumb" class="position-absolute bg-white breadcrumb-wrap">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                           <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                     </ol>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Promo Section End -->

   <!-- Login Section Start -->
   <section class="account-sec sec-padding">
      <div class="container">
         <div class="row">
            @if (session('status'))
                <p>{{ session('status') }}</p>
            @endif
            <div class="col-lg-7 mx-auto">
               <div class="text-center mb-2 pb-lg-5">
                  <h2 class="sec-title primary">Login Account</h2>
                  <p>Please log to access your account.</p>
               </div>
               <div class="account-form bg-shade round">
                  <div class="col-12 d-flex justify-content-center align-items-center mb-4">
                     <a href="#" class="btn btn-dark text-info w-100 text-center"><i class="fa-brands fa-google" style="margin-right: 15px;"></i> Login with Google</a>

                  </div>
                  <h5 class="h2 text-center mb-5">OR</h5>
                  <form method="post" action="{{ route('login.store') }}">
                    @csrf
                     <div class="form-group mb-3">
                        <input type="text" name="email" placeholder="Email Address*" required="">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                     </div>
                     <div class="form-group">
                        <input type="password" name="password" autocomplete="current-password" placeholder="Password*" required="">
                     </div>
                     <div class="d-flex justify-content-between my-4">
                        <div class="form-check">
                           <input class="form-check-input" name="remember" type="checkbox" value="" id="flexCheckChecked">
                           <label class="form-check-label" for="flexCheckChecked">
                              Remember me
                           </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-danger">Forgot Password?</a>
                     </div>
                     <button type="submit" name="submit" class="btn btn-primary w-100 mt-4">Login</button>
                  </form>
                  <div class="login-message text-center mt-5">
                     <p>Don’t have an account ? <a class="text-primary" href="{{ route('register') }}"> Register Now </a> </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- LOGING AREA END -->

@include('auth.partials.footer')
