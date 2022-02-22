<?php

namespace App\Http\Controllers\System;

use App\Models\Plan;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuscriptionController extends Controller
{
    public function index()
    {
        $intent = auth()->user()->createSetupIntent();
        $plans = Plan::all();
        $plan_status = Subscription::where('user_id', auth()->user()->id)->where('stripe_status', 'active')->first();

        return Inertia::render('System/Suscriptions/Index', compact('intent', 'plans', 'plan_status'));
    }

    public function subscribe(Request $request)
    {
        $data = json_decode($request->props);
        // auth()->user()->addPaymentMethod($data->card->payment_method);

        auth()->user()->newSubscription($data->plan->stripe_name, $data->plan->stripe_price_id)->create($data->card->payment_method);
        
        Auth::user()->profile()->update([
            'plan_id' => $data->plan->id,
        ]);

        return;
    }

    public function update($subscription)
    {
        $user = Auth::user();
        $user->subscription($subscription)->resume();
        return;
    }

    public function destroy($subscription)
    {
        $user = Auth::user();
        $user->subscription($subscription)->cancel();

        return;
    }
}
