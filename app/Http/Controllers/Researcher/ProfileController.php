<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        $page_title = "Complete your profile - ". env('APP_NAME');
        $user       = User::findOrFail(Auth::id());
        $profile     = $user->researchProfile();

        if ($profile) {
            return redirect()->route('profile.edit', $profile);
        }

        return view('profiles.create', ['page_title' => $page_title, 'user' => $user]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        
    }
}
