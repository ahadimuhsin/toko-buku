<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /*
         * Hanya ADMIN yang bisa memanage users
         * ADMIN/STAFF bisa memanage categories, books, orders
         * CUSTOMER untuk front end nanti
         */

        //mendefinisikan Gate yang bisa memanage users
        Gate::define('manage-users', function ($user){
            //memeriksa array, apakah di sana ada ADMIN di dalamnya
            return count(array_intersect(["ADMIN"], json_decode($user->roles)));
        });

        //mendefinisikan Gate yang bisa memanage categories
        Gate::define('manage-categories', function ($user){
            //memeriksa array, apakah di sana ada ADMIN atau STAFF di dalamnya
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles)));
        });

        //mendefinisikan Gate yang bisa memanage books
        Gate::define('manage-books', function ($user){
            //memeriksa array, apakah di sana ada ADMIN atau STAFF di dalamnya
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles)));
        });

        //mendefinisikan Gate yang bisa memanage orders
        Gate::define('manage-orders', function ($user){
            //memeriksa array, apakah di sana ada ADMIN atau STAFF di dalamnya
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles)));
        });
    }
}
