<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::post('/register', [AuthController::class, 'register']);




Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return response()->json([
        'message' => 'Email verified successfully',
    ]);
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request){
    $request->user()->sendEmailVerificationNotification();

    return response()->json([
        'message' => 'Email verification link sent successfully',
    ]);
})->middleware('auth:sanctum')->name('verification.send');

