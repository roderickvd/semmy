<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class HTTP extends Facade {

	/*
	|--------------------------------------------------------------------------
	| HTTP Facade
	|--------------------------------------------------------------------------
	|
	| This facade should implement a {get} method to access HTTP resources.
	|
	*/

	/**
	 * Get the name of the interface of this facade.
	 *
	 * @var array
	 */
	protected static function getFacadeAccessor() { return 'HTTP'; }

}

?>
