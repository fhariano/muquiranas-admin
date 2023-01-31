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

        Gate::define('gerenciar_bar', function () {

            return  session('group_id') == 1 || session('group_id') == 7;

        });

        Gate::define('visualizar_bar', function(){
            return session('group_id') != 6;
        });

        Gate::define('editar_bar', function(){
            return session('group_id') <= 2;
        });

        Gate::define('transferir_produto', function(){
            return session('group_id') <= 2 || session('group_id') == 7;
        });
          
        Gate::define('gerenciar_cardapio', function(){
            
            return session('group_id') <= 3;
        });

        Gate::define('gerenciar_listas', function(){
            
            return session('group_id') <= 4;
        });
        Gate::define('gerenciar_categoria', function(){
            
            return session('group_id') <= 4;
        });
        Gate::define('gerenciar_promocoes', function(){
            
            return session('group_id') <= 3;
        });

        Gate::define('visualizar_cardapio_bar', function(User $user, Products $products){
            
            return session('bar_id') == $products->bar_id;
        });

        Gate::define('bloquearDono_view', function () {
            return session('group_id') != 6;
        });

        // Gate::define('gerenciar_listas', function(User $user)){
        //     return $user->bar_id === 1;
        // }
        
    }
}
