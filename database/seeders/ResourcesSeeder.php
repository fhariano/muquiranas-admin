<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Resource::create(['name' => 'Bares']);
        $company->permissions()->create(['name' => 'visualizar_bares']);
        $company->permissions()->create(['name' => 'visualizar_bar']);
        $company->permissions()->create(['name' => 'editar_bar']);
        $company->permissions()->create(['name' => 'apagar_bar']);

        $category = Resource::create(['name' => 'Categorias']);
        $category->permissions()->create(['name' => 'visualizar_categorias']);
        $category->permissions()->create(['name' => 'visualizar_categoria']);
        $category->permissions()->create(['name' => 'editar_categoria']);
        $category->permissions()->create(['name' => 'apagar_categoria']);

        $product = Resource::create(['name' => 'Produtos']);
        $product->permissions()->create(['name' => 'visualizar_produtos']);
        $product->permissions()->create(['name' => 'visualizar_produto']);
        $product->permissions()->create(['name' => 'editar_produto']);
        $product->permissions()->create(['name' => 'apagar_produto']);

        $list = Resource::create(['name' => 'Listas']);
        $list->permissions()->create(['name' => 'visualizar_listas']);
        $list->permissions()->create(['name' => 'visualizar_lista']);
        $list->permissions()->create(['name' => 'editar_lista']);
        $list->permissions()->create(['name' => 'apagar_lista']);

        // $admin = Resouces::create(['name' => 'Admins']);
        // $admin->permissions()->create(['name' => 'users']);
        // $admin->permissions()->create(['name' => 'add_permissions_user']);
        // $admin->permissions()->create(['name' => 'del_permissions_user']);
    }
}
