<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Profile;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'username' => time(),
            'password' => Hash::make($input['password']),
            'profile_photo_path' => 'https://www.allkpop.com/upload/2021/10/content/071046/web_data/allkpop_1633618088_20211007-joyuri3.jpg',
        ]);

        Profile::create([
            'user_id' => $user->id,
            'plan_id' => 1,
        ]);

        return $user;
    }
}
