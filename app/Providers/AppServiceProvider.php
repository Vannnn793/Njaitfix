<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        // Paksa semua URL menjadi HTTPS
        // URL::forceScheme('https');

        // Composer view kamu
        View::composer('*', function ($view) {
            $layout = Auth::check() ? 'layouts.app' : 'layouts.guest';
            $view->with('layout', $layout);
        });

        
    }
}
