<?php

namespace App\Http\Controllers\System;

use App\Models\Plan;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuscriptionController extends Controller
{
    public function index()
    {
        $intent = auth()->user()->createSetupIntent();
        $plans = Plan::all();

        return Inertia::render('System/Suscriptions/Index', compact('intent', 'plans'));
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
}
