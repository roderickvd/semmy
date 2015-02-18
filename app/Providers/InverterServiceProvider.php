<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InverterServiceProvider extends ServiceProvider {

	/**
	 * Indicates that the loading of this provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap any inverter services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any inverter services.
	 *
	 * @return void
	 */
	public function register()
	{
		switch (env('INV_DRIVER')) {
			case 'stecagrid':
				$driver = 'StecaGrid';
				break;

			default:
				$this->app->abort(501, 'Configured driver not supported.');
				break;

		}

		$this->app->singleton('App\Contracts\Inverter', 'App\Services\Inverters\\'.$driver);
	}

	/**
	 * Get the services provided by this provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['App\Contracts\Inverter'];
	}

}
