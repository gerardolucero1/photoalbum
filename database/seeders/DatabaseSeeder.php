<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user = User::create([
            'name' => 'Gerardo Lucero',
            'email' => 'gera_conecta@hotmail.com',
            'password' => bcrypt('Margarit@1'),
            'profile_photo_path' => 'https://pm1.narvii.com/7473/ce61825edd978ec7e2a4427115bf3d23b18a8c40r1-1128-1504v2_hq.jpg',
        ]);

        $user = Profile::create([
            'user_id' => $user->id,
        ]);

        $plan = Plan::create([
            'name' => 'Free',
            'slug' => 'free',
            'stripe_name' => 'free',
            'stripe_id' => 'price_1KRhRiLwFtk4DPRSQitY5ovq',
            'price' => 0,
            'abbreviation' => '/free',
            'disk_space' => 10000,
        ]);

        $plan = Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'stripe_name' => 'basic',
            'stripe_id' => 'price_1KRhSILwFtk4DPRSZhGeFZLN',
            'price' => 2,
            'abbreviation' => '/basic',
            'disk_space' => 100000,
        ]);

        $plan = Plan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'stripe_name' => 'premium',
            'stripe_id' => 'price_1KRhStLwFtk4DPRSHjtU6ZCR',
            'price' => 5,
            'abbreviation' => '/premium',
            'disk_space' => 1000000,
        ]);
    }
}
