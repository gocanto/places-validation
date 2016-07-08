<?php
/*
 * This file is part of the Address Validation package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\AddressValidation;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
	/*
    * Indicates if loading of the provider is deferred.
    * @var bool
    */
    protected $defer = false;

	/**
	 * Perform post-registration booting of services.
	 * @return void
	 */
	public function boot()
	{
	    $this->publishes([
	    	__DIR__.'/Config/addressval.php' => config_path('addressval.php')
	    ]);
	}

	/**
     * Register bindings in the container.
     * @return void
     */
    public function register()
    {
    	//
    }

	/**
    * Get the services provided by the provider.
    * @return array
    */
    public function provides()
    {
        return ['address-validation'];
    }
}