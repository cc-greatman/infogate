@include('auth.partials.head')
@include('auth.partials.header')

<section class="promo-sec bg-cover jarallax" data-jarallax data-speed=".6">
    <img src="{{ asset('assets/images/promo-bg.jpg') }}" alt="" class="jarallax-img">
    <div class="parallax-overly"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="promo-wrap position-relative">
                    <h1 class="display-1 text-info text-center">
                        Edit Profile
                    </h1>

                    <nav aria-label="breadcrumb" class="position-absolute bg-white breadcrumb-wrap">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Profile
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="signup-sec sec-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <div class="contact-form2 bg-shade round p-4 p-lg-5">

                    <h2 class="h3 text-center mb-3">
                        Update Your Researcher Profile
                    </h2>

                    <p class="text-center mb-5">
                        Keep your academic affiliations and research interests up to date.
                    </p>

                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <p>Please correct the following errors:</p>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @php
                    $affiliationValues = old(
                        'affiliations',
                        $researcherProfile->affiliations->map(fn ($a) => [
                            'institution' => $a->institution,
                            'department' => $a->department,
                            'professional_title' => $a->professional_title,
                            'country' => $a->country ?? '',
                        ])->all()
                    );

                    $interestValues = old(
                        'research_interests',
                        $researcherProfile->researchInterests
                        ->pluck('interest')->all()
                    );
                    @endphp

                    <form method="POST" action="{{ route('profile.update', $researcherProfile) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Basic Information --}}
                        <h3 class="h5 mb-4">Basic Information</h3>

                        {{-- Researcher Photo --}}
                        <div class="form-group mb-4">
                            <label for="profile_photo">Profile Photo</label>

                            <div class="mb-3">
                                @if ($researcherProfile->profile_photo_path)
                                <img id="photo-preview" src="{{ asset('storage/' . $researcherProfile->profile_photo_path) }}" alt="Current researcher photo" class="rounded-circle border" style="width: 140px; height: 140px; object-fit: cover;">
                                @else
                                <img id="photo-preview" src="" alt="Photo preview" class="rounded-circle border d-none" style="width: 140px; height: 140px; object-fit: cover;">

                                <p id="no-photo-message" class="text-muted mb-0">
                                    No profile photo uploaded yet.
                                </p>
                                @endif
                            </div>

                            <input class="form-control" type="file" name="profile_photo" id="profile_photo" accept="image/jpeg,image/png,image/webp">

                            <small class="text-muted">
                                JPG, PNG, or WebP. Maximum size: 2 MB. Leave empty to keep your current photo.
                            </small>

                            @error('profile_photo')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="full_name">Full Name</label>
                            <input class="form-control" type="text" name="full_name" id="full_name" value="{{ old('full_name', $researcherProfile->full_name) }}" maxlength="255">
                            @error('full_name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="biography">Biography</label>

                            <div id="biography-editor" class="bg-white"></div>

                            <textarea
                                name="biography"
                                id="biography"
                                class="d-none"
                            >{{ old('biography', $researcherProfile->biography ?? '') }}</textarea>


                            @error('biography')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-5">
                            <label for="website_url">Website</label>
                            <input class="form-control" type="url" name="website_url" id="website_url" value="{{ old('website_url', $researcherProfile->website_url) }}" placeholder="https://your-website.com">
                            @error('website_url')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Affiliations --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="h5 mb-0">Affiliations</h3>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-affiliation">
                                + Add Affiliation
                            </button>
                        </div>

                        <p class="text-muted mb-4">
                            Edit your existing institutions or add new ones.
                        </p>

                        <div id="affiliations-container">
                            @foreach ($affiliationValues as $index => $affiliation)
                            <div class="affiliation-item border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="h6 mb-0">Affiliation</h4>
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-affiliation">
                                        Remove
                                    </button>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Institution</label>
                                    <input class="form-control" type="text" name="affiliations[{{ $index }}][institution]" value="{{ $affiliation['institution'] ?? '' }}" placeholder="University or organization">
                                    @error("affiliations.$index.institution")
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label>Department</label>
                                    <input class="form-control" type="text" name="affiliations[{{ $index }}][department]" value="{{ $affiliation['department'] ?? '' }}" placeholder="Department or faculty">
                                    @error("affiliations.$index.department")
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label>Professional Title</label>
                                    <input class="form-control" type="text" name="affiliations[{{ $index }}][professional_title]" value="{{ $affiliation['professional_title'] ?? '' }}" placeholder="Professor, Researcher, PhD Student...">
                                    @error("affiliations.$index.professional_title")
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="affiliations[{{ $index }}][country]">
                                        <option value="">Select country</option>
                                        @foreach ($countries as $code => $name)
                                        <option value="{{ $code }}" @selected(($affiliation['country'] ?? '' )===$code)>
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error("affiliations.$index.country")
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @error('affiliations')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                        {{-- Research Interests --}}
                        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                            <h3 class="h5 mb-0">Research Interests</h3>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-interest">
                                + Add Interest
                            </button>
                        </div>

                        <p class="text-muted mb-4">
                            Add or remove topics to reflect your current research.
                        </p>

                        <div id="interests-container">
                            @foreach ($interestValues as $index => $interest)
                            <div class="interest-item form-group d-flex align-items-start gap-2 mb-3">
                                <div class="flex-grow-1">
                                    <input class="form-control" type="text" name="research_interests[{{ $index }}]" value="{{ $interest }}" placeholder="e.g. Federated Learning">
                                    @error("research_interests.$index")
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="button" class="btn btn-outline-danger remove-interest">
                                    Remove
                                </button>
                            </div>
                            @endforeach
                        </div>

                        @error('research_interests')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="btn btn-primary w-100 mt-4">
                            Save Changes
                            <i class="fa fa-arrow-right ms-2"></i>
                        </button>

                        <a href="{{ route('profiles.show', $researcherProfile) }}" class="btn btn-outline-secondary w-100 mt-2">
                            Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const photoInput = document.getElementById('profile_photo');
        const photoPreview = document.getElementById('photo-preview');
        const noPhotoMessage = document.getElementById('no-photo-message');

        if (!photoInput || !photoPreview) {
            return;
        }

        let previewUrl = null;

        photoInput.addEventListener('change', function() {
            const file = this.files[0];

            if (!file) {
                return;
            }

            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
            }

            previewUrl = URL.createObjectURL(file);

            photoPreview.src = previewUrl;
            photoPreview.classList.remove('d-none');

            if (noPhotoMessage) {
                noPhotoMessage.classList.add('d-none');
            }
        });
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const biographyInput = document.getElementById('biography');
        const editorElement = document.getElementById('biography-editor');

        if (!biographyInput || !editorElement) {
            return;
        }

        const quill = new Quill(editorElement, {
            theme: 'snow'
            , placeholder: 'Describe your academic background, research, publications, and experience.'
            , modules: {
                toolbar: [
                    [{
                        header: [2, 3, false]
                    }]
                    , ['bold', 'italic', 'underline']
                    , [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }]
                    , ['link']
                    , ['clean']
                ]
            }
        });

        const initialBiography = biographyInput.value.trim();

        if (initialBiography) {
            quill.root.innerHTML = initialBiography;
        }

        const form = biographyInput.closest('form');

        if (form) {
            form.addEventListener('submit', function() {
                biographyInput.value = quill.root.innerHTML;
            });
        }
    });

</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const affiliationsContainer = document.getElementById('affiliations-container');
        const interestsContainer = document.getElementById('interests-container');
        const countries = @json($countries);

        let affiliationIndex = {
            {
                count($affiliationValues)
            }
        };
        let interestIndex = {
            {
                count($interestValues)
            }
        };

        function countryOptions() {
            let html = '<option value="">Select country</option>';

            for (const [code, name] of Object.entries(countries)) {
                html += `<option value="${code}">${name}</option>`;
            }

            return html;
        }

        document.getElementById('add-affiliation').addEventListener('click', () => {
            const index = affiliationIndex++;

            const item = document.createElement('div');
            item.className = 'affiliation-item border rounded p-3 mb-3';

            item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="h6 mb-0">New Affiliation</h4>
                <button type="button"
                    class="btn btn-outline-danger btn-sm remove-affiliation">
                    Remove
                </button>
            </div>

            <div class="form-group mb-3">
                <label>Institution</label>
                <input class="form-control" type="text"
                    name="affiliations[${index}][institution]"
                    placeholder="University or organization">
            </div>

            <div class="form-group mb-3">
                <label>Department</label>
                <input class="form-control" type="text"
                    name="affiliations[${index}][department]"
                    placeholder="Department or faculty">
            </div>

            <div class="form-group mb-3">
                <label>Professional Title</label>
                <input class="form-control" type="text"
                    name="affiliations[${index}][professional_title]"
                    placeholder="Professor, Researcher, PhD Student...">
            </div>

            <div class="form-group">
                <label>Country</label>
                <select class="form-control"
                    name="affiliations[${index}][country]">
                    ${countryOptions()}
                </select>
            </div>
        `;

            affiliationsContainer.appendChild(item);
        });

        document.getElementById('add-interest').addEventListener('click', () => {
            const index = interestIndex++;

            const item = document.createElement('div');
            item.className =
                'interest-item form-group d-flex align-items-start gap-2 mb-3';

            item.innerHTML = `
            <div class="flex-grow-1">
                <input class="form-control" type="text"
                    name="research_interests[${index}]"
                    placeholder="e.g. Federated Learning">
            </div>
            <button type="button"
                class="btn btn-outline-danger remove-interest">
                Remove
            </button>
        `;

            interestsContainer.appendChild(item);
        });

        affiliationsContainer.addEventListener('click', event => {
            const button = event.target.closest('.remove-affiliation');
            if (!button) return;

            button.closest('.affiliation-item').remove();
        });

        interestsContainer.addEventListener('click', event => {
            const button = event.target.closest('.remove-interest');
            if (!button) return;

            button.closest('.interest-item').remove();
        });
    });

</script>

@include('auth.partials.footer')
