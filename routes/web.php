<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('app/Http/Controller')->group(function()
{
    Route::name('auth')->middleware('auth')->prefix('auth')->group(function ()
    {
        route::get('/profile', 'Researcher\ProfileController@create')->name('profile.create');
        route::post('profile', 'Reseacrcher\ProfileController@store')->name('profile.create');
    });
});
