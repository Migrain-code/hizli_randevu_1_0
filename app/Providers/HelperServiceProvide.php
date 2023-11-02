<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvide extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        include app_path('Helpers/helper.php');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
