@include('auth.partials.head')
@include('auth.partials.header')

{{-- Promo Section Start --}}
<section class="promo-sec bg-cover jarallax" data-jarallax data-speed=".6">
    <img src="{{ asset('assets/images/promo-bg.jpg') }}" alt="" class="jarallax-img">

    <div class="parallax-overly"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="promo-wrap position-relative">
                    <h1 class="display-1 text-info text-center">
                        Reset Password
                    </h1>

                    <nav aria-label="breadcrumb" class="position-absolute bg-white breadcrumb-wrap">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Reset Password
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Promo Section End --}}

{{-- Reset Password Section Start --}}
<section class="account-sec sec-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto">

                <div class="text-center mb-2 pb-lg-5">
                    <h2 class="sec-title primary">
                        Create a New Password
                    </h2>
                    <p>
                        Choose a strong new password for your account.
                    </p>
                </div>

                <div class="account-form bg-shade round">

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

                    {{-- Reset Password Form --}}
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        {{-- Token from the reset URL --}}
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">
                                Email Address
                            </label>

                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" autocomplete="email" required readonly>

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">
                                New Password
                            </label>

                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your new password" autocomplete="new-password" required autofocus>

                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">
                                Confirm New Password
                            </label>

                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm your new password" autocomplete="new-password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4">
                            Reset Password
                        </button>
                    </form>

                    <div class="login-message text-center mt-4">
                        <p>
                            Remember your password?
                            <a class="text-primary" href="{{ route('login') }}">
                                Back to Login
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
{{-- Reset Password Section End --}}

@include('auth.partials.footer')
