<?php

use Illuminate\Support\Facades\Route;

Route::post('/generate-token', [App\Http\Controllers\API\GenerateAccessTokenController::class, 'generate_token']);