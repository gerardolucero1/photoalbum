<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => '123123',
            'password' => Hash::make($request->password),
            'profile_photo_path' => 'https://pm1.narvii.com/7473/ce61825edd978ec7e2a4427115bf3d23b18a8c40r1-1128-1504v2_hq.jpg',
        ]);
    }
}
