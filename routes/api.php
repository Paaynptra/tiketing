<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/verify-booking', [\App\Http\Controllers\Api\BookingController::class, 'verify']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Example protected route with Sanctum for mobile checkin app
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/checkin', function (Request $request) {
        // TODO: scan QR payload, validate HMAC, mark ticket used
        return response()->json(['status' => 'ok']);
    })->middleware('throttle:30,1');
});

// Payment webhooks (rate-limited)
Route::post('/webhooks/midtrans', function (Request $request) {
    // TODO: inject PaymentService & handle
    return response()->json(['received' => true]);
})->middleware('throttle:20,1');

Route::post('/webhooks/xendit', function (Request $request) {
    // TODO
    return response()->json(['received' => true]);
})->middleware('throttle:20,1');

