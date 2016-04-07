<?php namespace Joanvt\OneSignal;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

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
      
		if(!File::exists(config_path('onesignal.php'))){
			$this->publishes([__DIR__.'/../config/onesignal.php' => config_path('onesignal.php')], 'config');
		}
		
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