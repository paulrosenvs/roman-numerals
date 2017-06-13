<?php

namespace App\Providers;

use App\IntegerConversion;
use App\IntegerConversionInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IntegerConversionInterface::class, function ($app) {
            return new IntegerConversion();
        });
    }
}
