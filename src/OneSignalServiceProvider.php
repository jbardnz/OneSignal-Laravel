<?php namespace Joanvt\OneSignal;

use Illuminate\Support\ServiceProvider;

class OneSignalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        
		//config
        $this->publishes([__DIR__.'/../config/onesignal.php' => config_path('onesignal.php')], 'config');
        $this->mergeConfigFrom( __DIR__.'/../config/onesignal.php', 'onesignal');
		
		
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
		
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
    
}