<?php

namespace Database\Seeders;

use App\Models\UsersBar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersBarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userBar = UsersBar::create([
        'user_id' => 1,
        'bar_id' => 1,
        'group_id' => 1,
        'inserted_for' => 'Murilo'
             
        ]);
        $userBar = UsersBar::create([
            'user_id' => 1,
            'bar_id' => 2,
            'group_id' => 1,
            'is_owner' => true,
            'inserted_for' => 'Murilo'
        ]);

        $userBar = UsersBar::create([
            'user_id' => 2,
            'bar_id' => 1,
            'group_id' => 6,
            'is_owner' => true,
            'inserted_for' => 'Murilo'
        ]);
        $userBar = UsersBar::create([
            'user_id' => 2,
            'bar_id' => 2,
            'group_id' => 6,
            'is_owner' => true,
            'inserted_for' => 'Murilo'
            
        ]);
        $userBar = UsersBar::create([
            'user_id' => 3,
            'bar_id' => 1,
            'group_id' => 7, 
            'inserted_for' => 'Murilo'
        ]);
        $userBar = UsersBar::create([
            'user_id' => 3,
            'bar_id' => 1,
            'group_id' => 7, 
            'inserted_for' => 'Murilo'
        ]);
        $userBar = UsersBar::create([
            'user_id' => 4,
            'bar_id' => 1,
            'group_id' => 1, 
            'inserted_for' => 'Murilo'
        ]);
    }
}
