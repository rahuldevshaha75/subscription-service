<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }







    //=============================================List all packages=================================================
    public function packages()
    {
        return response()->json(Package::all());
    }







    //=============================================Subscribe user======================================================
    public function subscribe(Request $request)
    {
        // Converting type to Proper case
        $request->merge([
            'type' => ucfirst(strtolower($request->type))
        ]);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'package_id' => 'required|integer|exists:packages,id',
            'type' => 'required|in:Trial,Monthly',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $result = $this->subscriptionService->subscribe(
            $request->user_id,
            $request->package_id,
            $request->type
        );

        return response()->json($result['data'] ?? ['error' => $result['error']], $result['status']);
    }










    //=============================================Get current active subscription===========================================
    public function status($user_id)
    {
        $subscription = $this->subscriptionService->getCurrent($user_id);
        return response()->json($subscription);
    }








    //=============================================Get subscription history==================================================
    public function history($user_id)
    {
        $subscriptions = $this->subscriptionService->getHistory($user_id);
        return response()->json($subscriptions);
    }
}
