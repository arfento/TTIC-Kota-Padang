<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        //
       /*  Blade::directive('money', function ($value) {
            
            return "<?php 
            setlocale(LC_MONETARY, 'en_US');
echo money_format('%i', $value);
            
            
            echo number_format($value, 2); ?>";
        }); */
    }
}
