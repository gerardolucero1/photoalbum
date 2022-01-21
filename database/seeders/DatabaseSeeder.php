<?php

namespace Database\Seeders;

use App\Models\User;
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
            'profile_photo_path' => 'https://i.pinimg.com/474x/ec/19/dc/ec19dc36a10f81a89304c9faedc3896b.jpg',
            
        ]);
    }
}
