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
                    <h1 class="display-1 text-info text-center">Register</h1>
                    <nav aria-label="breadcrumb" class="position-absolute bg-white breadcrumb-wrap">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Register</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Promo Section End -->

<!-- Login Section Start -->
<section class="signup-sec sec-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="contact-form2 bg-shade round p-4 p-lg-5">
                    <h2 class="h3 text-center mb-5"> Create your Account</h2>
                    <form role="form" method="POST" action="{{ route('register.store') }}">
                        @csrf
                        <div class="form-group">
                            <input class="form-control" type="text" name="uname" id="uname" placeholder="Enter a username">
                            @error('uname')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input id="lname" class="form-control" type="text" name="lname" value="{{ old('lname') }}" placeholder="Enter your last name">
                                @error('lname')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <input id="oname" class="form-control" type="text" name="oname" placeholder="Enter your other names">
                                @error('oname')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" id="email" placeholder="Enter email">
                            @error('email')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Choose a password">
                            @error('password')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your chosen password">
                            @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary w-100 mt-4">Register Now<i class="fa fa-arrow-right"></i></button>
                        <div class="login-bottom mt-4">
                            <p class="text-center font-bold"><i class="fa fa-user me-2"></i> Already have an account to <a href="{{ route('login') }}" class="text-primary">Login here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('auth.partials.footer')
