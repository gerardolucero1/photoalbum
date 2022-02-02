<?php

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // $stripeCustomer = Auth::user()->createAsStripeCustomer();
        return Inertia::render('Web/Index');
    }
}
