<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            // 'bar_id' => 1,
            // 'group_id' => 1,
            'email' => 'fhariano@gmail.com',
            'name' => 'Flavio Ariano',
            'password'  => Hash::make('fhfa@2022'),
        ]);
        $user = User::create([
            // 'bar_id' => 1,
            // 'group_id' => 2,
            'email' => 'mcablack@gmail.com',
            'name' => 'Murilo Araújo',
            'password'  => Hash::make('mca@2022'),
        ]);
        $user = User::create([
            // 'bar_id' => 1,
            // 'group_id' => 3,
            'email' => 'mcablack3@gmail.com',
            'name' => 'Murilo Araújo 3',
            'password'  => Hash::make('mca@2022'),
        ]);
        $user = User::create([
            // 'bar_id' => 1,
            // 'group_id' => 4,
            'email' => 'mcablack4@gmail.com',
            'name' => 'Murilo Araújo 4',
            'password'  => Hash::make('mca@2022'),
        ]);
        $user = User::create([
            // 'bar_id' => 1,
            // 'group_id' => 5,
            'email' => 'mcablack5@gmail.com',
            'name' => 'Murilo Araújo 5',
            'password'  => Hash::make('mca@2022'),
        ]);
    }
}
