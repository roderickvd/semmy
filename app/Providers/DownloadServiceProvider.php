<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DownloadServiceProvider extends ServiceProvider {

	/**
	 * Indicates that the loading of this provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap any download services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any download services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('HTTP', 'App\Services\DownloadService');
	}

	/**
	 * Get the services provided by this provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['HTTP'];
	}

}
