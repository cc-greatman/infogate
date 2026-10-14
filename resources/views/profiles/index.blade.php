@include('auth.partials.head')

@include('auth.partials.header')

<section class="promo-sec bg-cover jarallax" data-jarallax data-speed=".6">
    <img src="{{ asset('assets/images/promo-bg.jpg') }}" alt="" class="jarallax-img">
    <div class="parallax-overly"></div>

    <div class="container">
        <div class="promo-wrap position-relative">
            <Researcher class="display-1 text-info text-center">Researcher Profile</h1>

            <nav aria-label="breadcrumb" class="position-absolute bg-white breadcrumb-wrap">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('profiles.index') }}">Humans</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Researchers
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Researcher Directory -->
<section class="team-sec2 sec-padding bg-light">
    <div class="container">

        <div class="sec-intro text-center">
            <span class="sub-title">Research Community</span>
            <h2 class="sec-title">Discover Researchers</h2>
            <p>Explore researchers, their affiliations and research interests.</p>
        </div>

        <!-- Search and filters -->
        <form method="GET" action="{{ route('profiles.index') }}" class="bg-white p-4 rounded mb-5 shadow-sm">

            <div class="row g-3 align-items-end">

                <div class="col-lg-12">
                    <label for="q" class="form-label">Search researchers</label>
                    <input type="search" class="form-control" id="q" name="q" value="{{ $search }}" placeholder="Name, institution, department, biography or research interest">
                </div>

                <div class="col-md-4">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" id="country" name="country">
                        <option value="">All countries</option>
                        @foreach ($countries as $code => $name)
                        <option value="{{ $code }}" @selected($country===$code)>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="institution" class="form-label">Institution</label>
                    <select class="form-select" id="institution" name="institution">
                        <option value="">All institutions</option>
                        @foreach ($institutions as $name)
                        <option value="{{ $name }}" @selected($institution===$name)>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="interest" class="form-label">Research interest</label>
                    <select class="form-select" id="interest" name="interest">
                        <option value="">All research interests</option>
                        @foreach ($interests as $name)
                        <option value="{{ $name }}" @selected($interest===$name)>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        Search and filter
                    </button>

                    <a href="{{ route('profiles.index') }}" class="btn btn-outline-secondary">
                        Clear filters
                    </a>
                </div>

            </div>
        </form>

        <!-- Result count -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="h5 mb-0">Researcher Directory</h3>
            <span class="text-muted">
                {{ $profiles->total() }} researcher(s) found
            </span>
        </div>

        <!-- Researcher cards -->
        <div class="row gy-4">

            @forelse ($profiles as $researcher)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-card2 hover-img h-100">

                    <div class="img-fluid position-relative overflow-hidden">
                        <a href="{{ route('profiles.show', $researcher) }}">
                            @php
                            $photo = $researcher->profile_photo_path
                            ? asset('storage/' . $researcher->profile_photo_path)
                            : asset('images/tm2.jpg');
                            @endphp

                            <img src="{{ $photo }}" alt="{{ $researcher->full_name }}" loading="lazy" style="width: 100%; height: 360px; object-fit: cover;">
                            <img src="{{ $photo }}" alt="" aria-hidden="true" loading="lazy" style="width: 100%; height: 360px; object-fit: cover;">
                        </a>
                    </div>

                    <div class="team-info bg-secondary">
                        <h3 class="h6 mb-2">
                            <a href="{{ route('profiles.show', $researcher) }}">
                                {{ $researcher->full_name }}
                            </a>
                        </h3>

                        <a href="{{ route('profiles.show', $researcher) }}" class="btn btn-sm btn-outline-light mt-3">
                            View profile
                        </a>
                    </div>

                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <h3 class="h5">No researchers found</h3>
                <p class="text-muted">
                    Try changing your search terms or removing some filters.
                </p>
                <a href="{{ route('profiles.index') }}" class="btn btn-outline-primary">
                    View all researchers
                </a>
            </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if ($profiles->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $profiles->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</section>

@include('auth.partials.footer')
