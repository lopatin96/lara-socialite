<?php

use Lopatin96\LaraSocialite\Http\Controllers\LaraSocialiteController;

Route::controller(LaraSocialiteController::class)->group(static function () {
    Route::get('/auth/{social}', 'socialLogin')
        ->whereIn('social', array_keys(config('lara-socialite.providers') ?? []));
    Route::get('/auth/{social}/callback', 'handleProviderCallback')
        ->whereIn('social', array_keys(config('lara-socialite.providers') ?? []));
});
