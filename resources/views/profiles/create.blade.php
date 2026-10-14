@include('auth.partials.head')
@include('auth.partials.header')

<!-- Promo Section Start -->
<section class="promo-sec bg-cover jarallax" data-jarallax data-speed=".6">
    <img src="{{ asset('assets/images/promo-bg.jpg') }}" alt="" class="jarallax-img">
    <div class="parallax-overly"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="promo-wrap position-relative">
                    <h1 class="display-1 text-info text-center">Researcher Profile</h1>

                    <nav aria-label="breadcrumb"
                         class="position-absolute bg-white breadcrumb-wrap">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create Profile
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Promo Section End -->

<!-- Profile Form Start -->
<section class="signup-sec sec-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <div class="contact-form2 bg-shade round p-4 p-lg-5">

                    <h2 class="h3 text-center mb-3">Complete Your Profile</h2>
                    <p class="text-center mb-5">
                        Introduce yourself, your affiliations, and your research interests.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->has('profile'))
                        <div class="alert alert-danger">
                            {{ $errors->first('profile') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.store') }}">
                        @csrf

                        <!-- Basic Information -->
                        <h3 class="h5 mb-4">Basic Information</h3>

                        <div class="form-group mb-4">
                            <label for="full_name">Full Name</label>
                            <input
                                class="form-control"
                                type="text"
                                name="full_name"
                                id="full_name"
                                readonly
                                value="{{ old('full_name', auth()->user()->name) }}"
                                placeholder="Enter your professional name">
                            @error('full_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="biography">Biography</label>
                            <textarea
                                class="form-control"
                                name="biography"
                                id="biography"
                                rows="5"
                                placeholder="Describe your academic background and work."
                            >{{ old('biography') }}</textarea>
                            @error('biography')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-5">
                            <label for="website_url">Website</label>
                            <input
                                class="form-control"
                                type="url"
                                name="website_url"
                                id="website_url"
                                value="{{ old('website_url') }}"
                                placeholder="https://your-website.com"
                            >
                            @error('website_url')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Affiliations -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="h5 mb-0">Affiliations</h3>
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                    id="add-affiliation">
                                + Add Affiliation
                            </button>
                        </div>

                        <p class="text-muted mb-4">
                            Add each university, research institution, or organization separately.
                        </p>

                        <div id="affiliations-container">
                            @forelse (old('affiliations', [['institution' => '', 'department' => '', 'professional_title' => '']]) as $index => $affiliation)
                                <div class="affiliation-item border rounded p-3 mb-3" data-affiliation-index="{{ $index }}">

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="h6 mb-0">Affiliation</h4>
                                        <button type="button"
                                                class="btn btn-outline-danger btn-sm remove-affiliation">
                                            Remove
                                        </button>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Institution</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            name="affiliations[{{ $index }}][institution]"
                                            value="{{ $affiliation['institution'] ?? '' }}"
                                            placeholder="University or organization"
                                        >
                                        @error("affiliations.$index.institution")
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Department</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            name="affiliations[{{ $index }}][department]"
                                            value="{{ $affiliation['department'] ?? '' }}"
                                            placeholder="Department or faculty"
                                        >
                                        @error("affiliations.$index.department")
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Professional Title</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            name="affiliations[{{ $index }}][professional_title]"
                                            value="{{ $affiliation['professional_title'] ?? '' }}"
                                            placeholder="Professor, Researcher, PhD Student..."
                                        >
                                        @error("affiliations.$index.professional_title")
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="affiliation_country_{{ $index }}">Country</label>

                                        <select class="form-control" name="affiliations[{{ $index }}][country]" id="affiliation_country_{{ $index }}">
                                            <option value="">Select country</option>

                                            @foreach ($countries as $code => $name)
                                            <option value="{{ $code }}" @selected( old("affiliations.$index.country")===$code )>
                                                {{ $name }}
                                            </option>
                                            @endforeach
                                        </select>

                                        @error("affiliations.$index.country")
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>

                        @error('affiliations')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <!-- Research Interests -->
                        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                            <h3 class="h5 mb-0">Research Interests</h3>
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                    id="add-interest">
                                + Add Interest
                            </button>
                        </div>

                        <p class="text-muted mb-4">
                            Add specific topics so people can discover your research.
                        </p>

                        <div id="interests-container">
                            @forelse (old('research_interests', ['']) as $index => $interest)
                                <div class="interest-item form-group d-flex align-items-start gap-2 mb-3">
                                    <div class="flex-grow-1">
                                        <input
                                            class="form-control"
                                            type="text"
                                            name="research_interests[{{ $index }}]"
                                            value="{{ $interest }}"
                                            placeholder="e.g. Federated Learning"
                                        >
                                        @error("research_interests.$index")
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="button"
                                            class="btn btn-outline-danger remove-interest">
                                        Remove
                                    </button>
                                </div>
                            @empty
                            @endforelse
                        </div>

                        @error('research_interests')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="btn btn-primary w-100 mt-4">
                            Save Researcher Profile
                            <i class="fa fa-arrow-right ms-2"></i>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Profile Form End -->

<script>
document.addEventListener('DOMContentLoaded', () => {
    const affiliationsContainer = document.getElementById('affiliations-container');
    const interestsContainer = document.getElementById('interests-container');

    let interestIndex = {{ count(old('research_interests', [''])) }};
    let affiliationIndex = {{ collect(old('affiliations', [
        ['institution' => '', 'department' => '', 'professional_title' => '', 'country' => '']
    ]))->keys()->max() + 1 }};


    document.getElementById('add-affiliation').addEventListener('click', () => {
        const items = document.querySelectorAll('.affiliation-item');
        const current = items[items.length - 1];

        if (!current) return;

        // Only allow progression when the institution is filled.
        const institutionInput = current.querySelector(
            '[name$="[institution]"]'
        );

        if (!institutionInput || !institutionInput.value.trim())
        {
            institutionInput?.focus();
            alert('Please enter an institution before adding another affiliation.');
            return;
        }

        // Preserve the current values as hidden form inputs.
        const fields = [
            'institution',
            'department',
            'professional_title',
            'country'
        ];

        const values = {};

        fields.forEach(field => {
            const input = current.querySelector(`[name$="[${field}]"]`);
            values[field] = input ? input.value.trim() : '';
        });

        const index = current.dataset.affiliationIndex;

        // Turn the completed affiliation into a text summary.
        const summary = document.createElement('div');
        summary.className = 'affiliation-summary';

        const heading = document.createElement('h4');
        heading.className = 'h6';
        heading.textContent = values.institution;
        summary.appendChild(heading);

        const details = document.createElement('p');
        details.className = 'mb-2 text-muted';
        details.textContent = [
            values.professional_title,
            values.department,
            values.country
            ? document.querySelector(
            `[name="affiliations[${index}][country]"]`
            )?.selectedOptions[0]?.textContent
            : ''
        ].filter(Boolean).join(' · ');
        summary.appendChild(details);

        fields.forEach(field => {
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = `affiliations[${index}][${field}]`;
        hidden.value = values[field];
        summary.appendChild(hidden);
        });

        current.replaceChildren(summary);
        current.dataset.locked = 'true';

        const countryOptions = `
            <option value="">Select country</option>
            @foreach ($countries as $code => $name)
            <option value="{{ $code }}">{{ $name }}</option>
            @endforeach
        `;

        // Create the next editable affiliation.
        const next = document.createElement('div');
        next.className = 'affiliation-item border rounded p-3 mb-3';
        next.dataset.affiliationIndex = affiliationIndex++;

        next.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="h6 mb-0">New Affiliation</h4>
                <button type="button" class="btn btn-outline-danger btn-sm remove-affiliation">
                    Remove
                </button>
            </div>

            <div class="form-group mb-3">
                <label>Institution</label>
                <input class="form-control" type="text" name="affiliations[${next.dataset.affiliationIndex}][institution]" placeholder="University or organization">
            </div>

            <div class="form-group mb-3">
                <label>Department</label>
                <input class="form-control" type="text" name="affiliations[${next.dataset.affiliationIndex}][department]" placeholder="Department or faculty">
            </div>

            <div class="form-group">
                <label>Professional Title</label>
                <input class="form-control" type="text" name="affiliations[${next.dataset.affiliationIndex}][professional_title]" placeholder="Professor, Researcher, PhD Student...">
            </div>

            <div class="form-group mb-3">
                <label>Country</label>
                <select class="form-control" name="affiliations[${next.dataset.affiliationIndex}][country]">
                    ${countryOptions}
                </select>
            </div>
        `;

    document.getElementById('affiliations-container').appendChild(next);
    });

    document.getElementById('add-interest').addEventListener('click', () => {
        const item = document.createElement('div');
        item.className = 'interest-item form-group d-flex align-items-start gap-2 mb-3';

        item.innerHTML = `
            <div class="flex-grow-1">
                <input class="form-control" type="text"
                       name="research_interests[${interestIndex}]"
                       placeholder="e.g. 3D Data">
            </div>
            <button type="button" class="btn btn-outline-danger remove-interest">Remove</button>
        `;

        interestsContainer.appendChild(item);
        interestIndex++;
    });

    affiliationsContainer.addEventListener('click', event => {
        const button = event.target.closest('.remove-affiliation');

        if (!button) return;

        const items = affiliationsContainer.querySelectorAll('.affiliation-item');

        if (items.length === 1)
        {
            alert('Keep at least one affiliation field.');
            return;
        }

        button.closest('.affiliation-item').remove();
    });


    interestsContainer.addEventListener('click', (event) => {
        if (event.target.closest('.remove-interest')) {
            event.target.closest('.interest-item').remove();
        }
    });
});
</script>

@include('auth.partials.footer')
