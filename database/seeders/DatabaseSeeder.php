<?php

namespace Database\Seeders;

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
        $this->call([
            BarSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PromosListsSeeder::class,
            ProductsPromosListsSeeder::class,
            ResourcesSeeder::class,
            GroupsSeeder::class,
            UsersSeeder::class,
            UsersBarsSeeder::class,
            PermissionsGroupsSeeder::class,
            OrderTypesSeeder::class,
            OrdersSeeder::class,
            OrdersItemsSeeder::class,
        ]);
    }
}
