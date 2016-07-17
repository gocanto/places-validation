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
use Gocanto\AddressValidation\Lib\Checker;

class ValidatorServiceProvider extends ServiceProvider
{
	/*
    * Indicates if loading of the provider is deferred.
    * @var bool
    */
    protected $defer = false;

    /**
     * Validation rule message
     * @var string
     */
    protected $validPlaceMessage = 'The address given is not valid. Please try another!';

    /**
     * Perform post-registration booting of services.
     *
     * @param  Checker $place
     * @return void
     */
	public function boot(Checker $place)
	{
	    $this->populateSettings();

        //We extend from the Validator object and add "valid_place", so you will be able
        //to use it as a rule within your validations.
        $this->app['validator']->extend('valid_place', function($attribute, $value, $parameters, $validator) use ($place) {

            //Evaluating validation for a given address.
            return $place->validate($value);

        }, $this->validPlaceMessage);
	}

    /**
     * publishes the setting files into the user app.
     * @return void
     */
    protected function populateSettings()
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