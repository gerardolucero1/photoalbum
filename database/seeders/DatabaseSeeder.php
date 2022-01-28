<?php

namespace Database\Seeders;

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
    }
}
