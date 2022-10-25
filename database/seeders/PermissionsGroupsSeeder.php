<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PermissionsGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions_groups')->insert([
            ['group_id' => 2, 'permission_id' => 1],
            ['group_id' => 2, 'permission_id' => 2],
            ['group_id' => 2, 'permission_id' => 3],
            ['group_id' => 2, 'permission_id' => 4],
            ['group_id' => 2, 'permission_id' => 5],
            ['group_id' => 2, 'permission_id' => 6],
            ['group_id' => 2, 'permission_id' => 7],
            ['group_id' => 2, 'permission_id' => 8],
            ['group_id' => 2, 'permission_id' => 9],
            ['group_id' => 2, 'permission_id' => 10],
            ['group_id' => 2, 'permission_id' => 11],
            ['group_id' => 2, 'permission_id' => 12],
        ]);
    }
}
