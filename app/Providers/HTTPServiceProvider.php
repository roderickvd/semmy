<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Log;

class HTTPServiceProvider extends ServiceProvider {

	/**
	 * Indicates that the loading of this provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap any HTTP services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any HTTP services.
	 *
	 * @return void
	 */
	public function register()
	{
		if (function_exists('curl_version')) {
			$driver = 'cURLService';

		} else if (ini_get('allow_url_fopen')) {
			$driver = 'fopenService';

		} else {
			Log::error('Load the cURL module or enable allow_url_fopen in your PHP configuration.');

		}

		$this->app->singleton('App\Contracts\HTTP', 'App\Services\HTTP\\'.$driver);		
	}

	/**
	 * Get the services provided by this provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['App\Contracts\HTTP'];
	}

}
