<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
	    view()->composer([
                'layouts.sidebar', 
                'layouts.breadcrumb'
            ],
            'App\Http\ViewComposers\NavigationComposer'
        );

        view()->composer('partials.buttons.*','App\Http\ViewComposers\ActionsComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}