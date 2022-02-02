<?php

namespace App\Http\Controllers\System;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuscriptionController extends Controller
{
    public function index()
    {
        return Inertia::render('System/Suscriptions/Index');
    }

    public function subscribe(Request $request)
    {
        Auth::user()->newSubscription(
            'default', 'price_monthly'
        )->create($request->paymentMethodId);
    }
}
