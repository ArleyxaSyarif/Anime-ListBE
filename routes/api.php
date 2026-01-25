<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {

    $user = User::find($id);

    // cek hash email
    if(! hash_equals(
        sha1($user->getEmailForVerification()),
        $hash
    )) {
        abort(403, 'invalid verification link');
    }

  // kalau belum diverifikasi
    if(! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

     // redirect ke frontend
    return redirect('http://localhost:3000/auth/verify');
})->name('verification.verify');



Route::post('/email/verification-notification', function (Request $request){
    $request->user()->sendEmailVerificationNotification();

    return response()->json([
        'message' => 'Email verification link sent successfully',
    ]);
})->middleware('auth:sanctum')->name('verification.send');


Route::middleware('auth:sanctum')->get('/user-profile', function (Request $request) {
    return response()->json(['user' => $request->user()]);
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'User logged out successfully',
    ]);
});

