<?php

namespace App\Http\Controllers\System;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request, $id)
    {
        $data = json_decode($request->props);

        $profile = Profile::find($id);
        $profile->name = $data->name;
        $profile->last_name = $data->last_name;
        $profile->city = $data->city;
        $profile->state = $data->state;
        $profile->country = $data->country;
        $profile->direction = $data->direction;
        $profile->cp = $data->cp;
        $profile->save();

        return;
    }

    public function getSize()
    {
        $user = Auth::user();
        $total = $user->photos->sum('size') / 1000000;

        return $total;
    }
}
