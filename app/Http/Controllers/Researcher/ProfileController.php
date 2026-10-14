<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
}
