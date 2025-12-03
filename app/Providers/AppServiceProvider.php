<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Leave;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $pendingCount = Leave::where('status', 'pending')->count();
            $view->with('pendingCount', $pendingCount);
        });
    }
}
