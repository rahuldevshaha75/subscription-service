<?php

namespace App\Services;

use App\Models\Subscription;
use Illuminate\Support\Carbon;

class SubscriptionService
{
    public function subscribe(int $user_id, int $package_id, string $type): array
    {
        $type = ucfirst(strtolower($type)); // ensure first letter capital




        


        //=============================================Prevent multiple Trials======================================================
        if ($type === 'Trial' && Subscription::where('user_id', $user_id)->where('type', 'Trial')->exists()) {
            return ['error' => 'User already used Trial', 'status' => 400];
        }






        //=============================================Check existing active subscriptions======================================================
        $activeSubscription = Subscription::where('user_id', $user_id)
            ->where('ends_at', '>', now())
            ->latest()
            ->first();

        if ($activeSubscription) {
            // Trial → Paid shift allowed
            if ($activeSubscription->type === 'Trial' && $type !== 'Trial') {
                // Close the Trial
                $activeSubscription->ends_at = now();
                $activeSubscription->save();
            } else {
                // Any other case: cannot subscribe to new package
                return ['error' => 'User already has an active subscription', 'status' => 400];
            }
        }




        //=============================================Calculate ends_at (30 days)======================================================
        $ends_at = Carbon::now()->addDays(30);

        $subscription = Subscription::create([
            'user_id' => $user_id,
            'package_id' => $package_id,
            'type' => $type,
            'starts_at' => now(),
            'ends_at' => $ends_at,
        ]);

        return ['data' => $subscription, 'status' => 201];
    }




    //=============================================Active Status======================================================
    public function getCurrent(int $user_id)
    {
        return Subscription::where('user_id', $user_id)
            ->where('ends_at', '>', now())
            ->latest()
            ->first();
    }




    //=============================================Full History======================================================
    public function getHistory(int $user_id)
    {
        return Subscription::where('user_id', $user_id)
            ->orderBy('starts_at', 'desc')
            ->get();
    }
}
