<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Group;
use App\Models\Products;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //TESTES GATE
        $this->registerPolicies();
        Gate::define('gerenciar_bar', function(User $user){
            return $user->group_id == 1;
        });

        Gate::define('visualizar_bar', function(User $user){
            return $user->group_id <= 5;
        });

        Gate::define('editar_bar', function(User $user){
            return $user->group_id <= 2;
        });

        Gate::define('transferir_produto', function(User $user){
            return $user->group_id <= 2;
        });
          
        Gate::define('gerenciar_cardapio', function(User $user){
            
            return $user->group_id <= 3;
        });

        Gate::define('gerenciar_listas', function(User $user){
            
            return $user->group_id <= 4;
        });
        Gate::define('gerenciar_categoria', function(User $user){
            
            return $user->group_id <= 4;
        });
        Gate::define('gerenciar_promocoes', function(User $user){
            
            return $user->group_id <= 3;
        });

        Gate::define('visualizar_cardapio_bar', function(User $user, Products $products){
            
            return $user->bar_id == $products->bar_id;
        });

        // Gate::define('gerenciar_listas', function(User $user)){
        //     return $user->bar_id === 1;
        // }
        
    }
}
