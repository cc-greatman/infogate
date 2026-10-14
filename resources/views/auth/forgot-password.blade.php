@include('auth.partials.head')

@include('auth.partials.header')

{{-- Promo Section Start --}}
<section class="promo-sec bg-cover jarallax" data-jarallax data-speed=".6">
    <img src="{{ asset('assets/images/promo-bg.jpg') }}"
         alt=""
         class="jarallax-img">

    <div class="parallax-overly"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="promo-wrap position-relative">
                    <h1 class="display-1 text-info text-center">
                        Forgot Password
                    </h1>

                    <nav aria-label="breadcrumb"
                         class="position-absolute bg-white breadcrumb-wrap">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active"
                                aria-current="page">
                                Forgot Password
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Promo Section End --}}

{{-- Forgot Password Section Start --}}
<section class="account-sec sec-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto">

                <div class="text-center mb-2 pb-lg-5">
                    <h2 class="sec-title primary">Reset Your Password</h2>
                    <p>
                        Forgot your password? Enter the email address
                        associated with your account and we'll send you
                        a password reset link.
                    </p>
                </div>

                <div class="account-form bg-shade round">

                    {{-- Status Message --}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter your registered email address"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                autofocus
                            >
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100 mt-4">
                            Send Password Reset Link
                        </button>
                    </form>

                    <div class="login-message text-center mt-4">
                        <p>
                            Remember your password?
                            <a class="text-primary"
                               href="{{ route('login') }}">
                                Back to Login
                            </a>
                        </p>

                        <p>
                            Don't have an account?
                            <a class="text-primary"
                               href="{{ route('register') }}">
                                Register Now
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
{{-- Forgot Password Section End --}}

@include('auth.partials.footer')
