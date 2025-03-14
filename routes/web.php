<?php

use Lopatin96\LaraSocialite\Http\Controllers\LaraSocialiteController;

Route::middleware('web')->controller(LaraSocialiteController::class)->group(static function () {
    Route::get('/auth/{social}', 'socialLogin')
        ->whereIn('social', config('lara-socialite.providers') ?? []);
    Route::get('/auth/{social}/callback', 'handleProviderCallback')
        ->whereIn('social', config('lara-socialite.providers') ?? []);
});
