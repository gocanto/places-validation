<?php

namespace Gocanto\AddressValidation\Lib;

class Checker
{
	/**
	 * Default driver.
	 * @var string
	 */
	private $default = 'GeoogleGeocode';

	/**
	 * Drivers map.
	 * @var array
	 */
	private $drivers = [
		'GeoogleGeocode' => \Gocanto\AddressValidation\Lib\drivers\GeoogleGeocode::class
	];

	/**
	 * Validation driver object.
	 * @var object
	 */
	private $driver = null;

	/**
	 * Driver configuration info.
	 * @var array
	 */
	private $config = null;

	/**
	 * Create a new instance.
	 */
	public function __construct()
	{
		$this->config = $this->resolveConfig();
		$this->driver = $this->resolveDriver();
	}

	/**
	 * Resolve the driver config info
	 * @return array
	 */
	private function resolveConfig()
	{
		$config = config('addressval.driver');

		if ($config) {
			return $config;
		}

		return $this->defaultDriver();
	}

	/**
	 * Returns the default driver.
	 * @return array
	 */
	private function defaultDriver()
	{
		return [
	        'key' => '',
	        'name' => 'GeoogleGeocode',
	        'api' => 'http://maps.google.com/maps/api/geocode/json'
    	];
	}

	/**
	 * Return a new driver instance.
	 * @param  array $driver
	 * @return driver
	 */
	private function resolveDriver()
	{
		if ($this->isDrivable()) {
			return $this->createInstanceFor($this->config["name"]);
		}

		return $this->createInstanceFor($this->default);
	}

	/**
	 * Check whether the driver given is valid.
	 * @return boolean
	 */
	private function isDrivable()
	{
		$driver = $this->config["name"];

		return isset($this->drivers[$driver]);
	}

	/**
	 * Create a new instance for a given driver.
	 * @param  string $driver
	 * @return driver
	 */
	private function createInstanceFor(string $driver)
	{
		echo $driver;
		return new $this->drivers[$driver]($this->config);
	}

	/**
	 * Call methods for a given driver.
	 * @param  String $method
	 * @param  Array $arguments
	 * @return Driver|Exception
	 */
	public function __call($method, $arguments)
    {
    	$arguments = (string) implode(', ', $arguments);

    	if (method_exists($this->driver, $method)) {
    		return $this->driver->$method($arguments);
    	}

    	throw new \Exception('The method "'.$method.'" does not exist in the class: ' . get_class($this->driver));
    }
}