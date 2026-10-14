<?php

use App\Http\Controllers\Researcher\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('profiles.index');
});

Route::namespace('App\Http\Controllers')->group(function()
{

    route::get('profile', [ProfileController::class, 'index'])->name('profiles.index');
    route::get('profile/{researcherProfile}', [ProfileController::class, 'show'])->name('profiles.show');

    Route::middleware('auth')->prefix('auth')->group(function ()
    {
        route::get('profile-create', [ProfileController::class, 'create'])->name('profile.create');
        route::get('profile/{researcherProfile}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        route::put('profile/{researcherProfile}', [ProfileController::class, 'update'])->name('profile.update');
        route::post('profile', [ProfileController::class, 'store'])->name('profile.store');
    });
});
