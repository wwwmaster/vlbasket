<?php

namespace Vl\Basket;

use Illuminate\Support\ServiceProvider;

class BasketServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {

        $this->loadViewsFrom(__DIR__ . '/views', 'basket');
        
        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/basket'),
        ]);
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        include __DIR__ . '/routes.php';
        $this->app->make('Vl\Basket\BasketController');
        
    }

}
