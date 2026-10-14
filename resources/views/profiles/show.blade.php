@include('auth.partials.head')
@include('auth.partials.header')

<section class="promo-sec bg-cover jarallax" data-jarallax data-speed=".6">
    <img src="{{ asset('assets/images/promo-bg.jpg') }}"
         alt="" class="jarallax-img">
    <div class="parallax-overly"></div>

    <div class="container">
        <div class="promo-wrap position-relative">
            <h1 class="display-1 text-info text-center">{{ $user->name }}'s Researcher Profile</h1>

            <nav aria-label="breadcrumb"
                 class="position-absolute bg-white breadcrumb-wrap">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('profiles.index') }}">Humans</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $researcherProfile->full_name ?: 'Researcher' }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>


<!-- Team Details Section Start -->
<section class="team-details-page main sec-padding overflow-hidden">
    <div class="container">
        <div class="row gx-5">

            <!-- Researcher Sidebar -->
            <div class="col-lg-4">
                <aside class="team-sidebar bg-light">

                    <div class="team-media">
                        {{-- Add a profile image field later if needed. --}}
                        <img src="{{ asset('assets/images/tm2.jpg') }}" class="img-fluid" alt="{{ $researcherProfile->full_name ?: 'Researcher' }}">
                    </div>

                    <div class="team-head">
                        <h3 class="display-4 mb-1">
                            {{ $researcherProfile->full_name ?: 'Researcher' }}
                        </h3>

                        @if ($researcherProfile->affiliations->isNotEmpty())
                        <span>
                            {{ $researcherProfile->affiliations
                                    ->pluck('professional_title')
                                    ->filter()
                                    ->unique()
                                    ->implode(' · ') }}
                        </span>
                        @endif
                    </div>

                    <div class="team-info">

                        @if ($researcherProfile->country)
                        <div class="ts-info">
                            <h6>Country:</h6>
                            <span>
                                {{ \Symfony\Component\Intl\Countries::getName(
                                        $researcherProfile->country,
                                        'en'
                                    ) }}
                            </span>
                        </div>
                        @endif

                        <div class="ts-info">
                            <h6>Email:</h6>
                            <span>
                                {{ $researcherProfile->user->email }}
                            </span>
                        </div>

                        @if ($researcherProfile->website_url)
                        <div class="ts-info">
                            <h6>Website:</h6>
                            <a href="{{ $researcherProfile->website_url }}" target="_blank" rel="noopener noreferrer">
                                Visit website
                            </a>
                        </div>
                        @endif

                        <div class="ts-info">
                            <h6>Affiliations:</h6>

                            @forelse ($researcherProfile->affiliations as $affiliation)
                            <div class="mb-3">
                                <strong>{{ $affiliation->institution }}</strong>

                                @if ($affiliation->department)
                                <div>{{ $affiliation->department }}</div>
                                @endif

                                @if ($affiliation->professional_title)
                                <small class="text-muted">
                                    {{ $affiliation->professional_title }}
                                </small>
                                @endif
                            </div>
                            @empty
                            <span>No affiliations listed.</span>
                            @endforelse
                        </div>

                        @auth
                        @if (auth()->id() === $researcherProfile->user_id)
                        <div class="ts-info mt-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary w-100">
                                Edit Profile
                                <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                        @endif
                        @endauth

                    </div>
                </aside>
            </div>

            <!-- Researcher Details -->
            <div class="col-lg-8 ps-lg-5">
                <div class="team-p-details">

                    <h2 class="display-4 mt-0">Biography</h2>

                    @if ($researcherProfile->biography)
                    <p>{{ $researcherProfile->biography }}</p>
                    @else
                    <p class="text-muted">
                        This researcher has not added a biography yet.
                    </p>
                    @endif

                    <h3 class="display-4 mt-5">Research Interests</h3>

                    @if ($researcherProfile->researchInterests->isNotEmpty())
                    <ul class="d-flex flex-nowrap align-items-center gap-2 list-unstyled m-0 p-0 overflow-x-auto py-2">
                        @foreach ($researcherProfile->researchInterests as $interest)
                        <li class="badge bg-primary text-white py-2 px-3 rounded-pill fw-normal fs-6 text-nowrap flex-shrink-0">
                            {{ $interest->interest }}
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">
                        No research interests have been added yet.
                    </p>
                    @endif

                    <h3 class="display-4 mt-5">Professional Affiliations</h3>

                    @forelse ($researcherProfile->affiliations as $affiliation)
                    <div class="border rounded p-4 mb-3">
                        <h4 class="h5 mb-2">
                            {{ $affiliation->institution }}
                        </h4>

                        @if ($affiliation->professional_title)
                        <p class="mb-1">
                            {{ $affiliation->professional_title }}
                        </p>
                        @endif

                        @if ($affiliation->department)
                        <p class="text-muted mb-0">
                            {{ $affiliation->department }}
                        </p>
                        @endif

                        <h5 class="h6 mt-4">
                            {{ \Symfony\Component\Intl\Countries::getName($affiliation->country, 'en') }}
                        </h5>
                    </div>
                    @empty
                    <p class="text-muted">
                        No professional affiliations have been added yet.
                    </p>
                    @endforelse

                    <div class="mt-5">
                        <a href="{{ route('profiles.index') }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left me-2"></i>
                            Back to Researchers
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- Team Details Section End -->

@include('auth.partials.footer')
