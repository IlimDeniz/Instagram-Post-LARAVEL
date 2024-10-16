<?php

use App\Http\Controllers\InstagramController;

Route::get('login/instagram', [InstagramController::class, 'loginInstagram']);
Route::get('instagram/callback', [InstagramController::class, 'instagramCallback']);
Route::get('instagram/posts', [InstagramController::class, 'instagramFetchPost']);

Route::get('/', function () {
    return view('welcome');
});
