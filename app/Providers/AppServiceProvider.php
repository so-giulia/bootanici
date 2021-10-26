<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Braintree\Gateway;


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
        $this->app->singleton(Gateway::class, function($app){
            return new Gateway(
            [
                'environment' => 'sandbox',
                'merchantId' => 'yj6k2rfw49969vmd',
                'publicKey' => 'y6wdx4nxpvp5gm8v',
                'privateKey' => '3d346f2ef6d76c0db37cdc28bf20164f'
            ]
            );
        });
    }
}
