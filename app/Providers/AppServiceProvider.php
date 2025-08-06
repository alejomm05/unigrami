<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
   public function boot()
{
    // Compartir $possibleRecipients en todas las vistas
    View::composer('*', function ($view) {
        $possibleRecipients = collect();

        if (Auth::check()) {
            $possibleRecipients = User::whereHas('followers', function ($query) {
                $query->where('follower_id', Auth::id());
            })->get();
        }

        $view->with('possibleRecipients', $possibleRecipients);
    });
}
}