<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

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
        switch (env('INV_DRIVER')) {
            case 'stecagrid':
                $driver = 'App\Services\StecaGrid';
                break;
        }

		$this->app->singleton('App\Contracts\Inverter', $driver);
	}

}
