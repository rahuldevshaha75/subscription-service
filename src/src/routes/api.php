<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;

// List all packages
Route::get('/packages', [SubscriptionController::class, 'packages']);

// Subscribe a user
Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);

// Check active subscription status
Route::get('/subscription-status/{user_id}', [SubscriptionController::class, 'status']);

// View user's subscription history
Route::get('/subscription-history/{user_id}', [SubscriptionController::class, 'history']);


// Test route
Route::get('/test-server', function() {
    return 'Yes!! Running!';
});
