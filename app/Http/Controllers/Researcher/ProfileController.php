<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use App\Models\ResearcherProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Mews\Purifier\Facades\Purifier;
use Throwable;

class ProfileController extends Controller
{
    public function create()
    {
        $page_title = "Complete your profile - ". env('APP_NAME');
        $user       = User::findOrFail(Auth::id());
        $profile     = $user->researchProfile();
        $countries  = \Symfony\Component\Intl\Countries::getNames('en');

        asort($countries);

        /*if ($profile) {
            return redirect()->route('profile.edit', $profile);
        }*/

        return view('profiles.create', ['page_title' => $page_title, 'user' => $user, 'countries' => $countries]);
    }

    public function edit(ResearcherProfile $researcherProfile)
    {
        abort_unless(Auth::id() === $researcherProfile->user_id, 403);

        $page_title = "Edit your profile - ". env('APP_NAME');
        $user = $researcherProfile->user();

        $researcherProfile->load([
            'affiliations',
            'researchInterests'
        ]);

        $countries = \Symfony\Component\Intl\Countries::getNames('en');
        asort($countries);

        return view('profiles.edit', ['countries' => $countries, 'page_title' => $page_title,
                                     'user' => $user, 'researcherProfile' => $researcherProfile]);
    }

    public function show(ResearcherProfile $researcherProfile)
    {
        $user = $researcherProfile->user;
        $page_title = $user->name. "\'s Profile - ". env('APP_NAME');
        $researcher = $researcherProfile->load(
            [
                'user',
                'affiliations',
                'researchInterests'
            ]
        );

        return view('profiles.show', ['researcherProfile' => $researcher, 'page_title' => $page_title, 'user' => $user]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if($user->researchProfile()->exists())
        {
            return redirect()->route('profile.create')
                             ->withErrors(['profile' => 'You already have a profile']);
        }

        $validated = $request->validate([
            'biography'   => ['nullable', 'string'],
            'website_url' => ['nullable', 'string', 'max:255'],

            'affiliations'                      => ['nullable', 'array'],
            'affiliations.*.institution'        => ['required_with:affiliations', 'string', 'max:255'],
            'affiliations.*.country'            => ['nullable', 'string', 'size:2',
                                                  Rule::in(array_keys(\Symfony\Component\Intl\Countries::getNames('en')))],
            'affiliations.*.department'         => ['nullable', 'string', 'max:255'],
            'affiliations.*.professional_title' => ['nullable', 'string', 'max:255'],

            'research_interests'   => ['nullable', 'array'],
            'research_interests.*' => ['required', 'string', 'max:255'],
        ]);

        $validated['biography'] = isset($validated['biography']) ? Purifier::clean(
                                                                   $validated['biography']) : null;

        DB::transaction(function () use ($user, $validated) {
            $profile = $user->researchProfile()->create([
                'full_name'   => $user->name,
                'biography'   => $validated['biography'] ?? null,
                'website_url' => $validated['website_url'] ?? null,
                'country'     => $validated['country'] ?? null
            ]);

            $profile->affiliations()->createMany(
                $validated['affiliations'] ?? []
            );

            $profile->researchInterests()->createMany(
                collect($validated['research_interests'] ?? [])
                ->map(fn ($interest) => ['interest' => $interest])
                ->all()
            );
        });
    }

    public function update(ResearcherProfile $researcherProfile, Request $request)
    {
        abort_unless(Auth::id() === $researcherProfile->user_id, 403);

        $countries = array_keys(\Symfony\Component\Intl\Countries::getNames('en'));

        $validated = $request->validate([
            'biography' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url', 'max:255'],

            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'affiliations' => ['nullable', 'array'],
            'affiliations.*.institution' => ['required', 'string', 'max:255'],

            'affiliations.*.country' => ['nullable', 'string', 'size:2', Rule::in($countries)],

            'affiliations.*.department' => ['nullable', 'string', 'max:255'],

            'affiliations.*.professional_title' => ['nullable', 'string', 'max:255'],

            'research_interests' => ['nullable', 'array'],
            'research_interests.*' => ['required', 'string', 'max:255'],
        ]);

        $oldPhotoPath = $researcherProfile->profile_photo_path;
        $newPhotoPath = null;

        if ($request->hasFile('profile_photo')) {
            $newPhotoPath = $request->file('profile_photo')
            ->store('researcher-photos', 'public');
        }

        $validated['biography'] = isset($validated['biography']) ? Purifier::clean(
                                                                   $validated['biography']) : null;

        try {
            DB::transaction(function () use ($researcherProfile, $validated, $newPhotoPath) {
                $profileData = [
                    'biography' => $validated['biography'] ?? null,
                    'website_url' => $validated['website_url'] ?? null,
                ];

                if ($newPhotoPath !== null) {
                    $profileData['profile_photo_path'] = $newPhotoPath;
                }

                $researcherProfile->update($profileData);

                // Replace the existing affiliations.
                $researcherProfile->affiliations()->delete();

                $researcherProfile->affiliations()->createMany(
                    $validated['affiliations'] ?? []
                );

                // Replace the existing research interests.
                $researcherProfile->researchInterests()->delete();

                $researcherProfile->researchInterests()->createMany(
                    collect($validated['research_interests'] ?? [])
                    ->map(fn ($interest) => [
                    'interest' => $interest,
                    ])
                    ->all()
                );
            });
        } catch (Throwable $exception) {

            if ($newPhotoPath !== null) {
                Storage::disk('public')->delete($newPhotoPath);
            }

            throw $exception;
        }

        if ($newPhotoPath !== null && $oldPhotoPath !== null)
        {
            Storage::disk('public')->delete($oldPhotoPath);
        }

        return redirect()
        ->route('profiles.show', $researcherProfile)
        ->with('success', 'Your researcher profile has been updated.');
    }
}
