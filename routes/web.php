<?php

use App\Http\Controllers\Researcher\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('App\Http\Controllers')->group(function()
{
    Route::middleware('auth')->prefix('auth')->group(function ()
    {
        route::get('profile-create', [ProfileController::class, 'create'])->name('profile.create');
        route::post('profile', [ProfileController::class, 'store'])->name('profile.store');
    });
});
