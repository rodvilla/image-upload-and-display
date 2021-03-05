<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('image-upload', App\Http\Controllers\Api\ImageUploadController::class)
    ->name('image-upload');
