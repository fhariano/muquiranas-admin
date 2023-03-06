<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = Group::create(['name' => 'Super Admin']);
        $groups = Group::create(['name' => 'Admin']);
        $groups = Group::create(['name' => 'Gerente']);
        $groups = Group::create(['name' => 'Supervisor']);
        $groups = Group::create(['name' => 'Usuário']);
        $groups = Group::create(['name' => 'DonoBar']);
        $groups = Group::create(['name' => 'MultiAdmin']);
    }
}
