<?php

namespace Gocanto\AddressValidation\Lib;

use App\Services\Places\Contract;

class GeoogleGeocode implements Contract
{
    /**
     * Indicates when there was no results from google.
     */
	const ZERO_RESULTS = 'ZERO_RESULTS';

    /**
     * Google place object.
     * @var null
     */
    private $place = null;

    /**
     * Driver configuration info.
     * @var array
     */
    private $config = null;

    /**
     * Create a new instance.
     */
    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * fetch an address from google geocode api.
     * @param  string $address
     * @return array
     */
    private function fetchAddress(string $address)
    {
        return json_decode(
            file_get_contents($this->resolveUrl($address)),
            true
        );
    }

    /**
     * Build the google request url for a given address.
     * @param  string $address
     * @return string
     */
    private function resolveUrl(string $address)
    {
        return $this->config['api'] .'?address='. urlencode($address);
    }

    /**
     * Validate whether a given address is valid.
     * @param  string $address
     * @return Mixed
     */
    public function validate(string $address)
    {
        $this->place = $this->fetchAddress($address);

		if ($this->placeDoesntExist()) {
            return false;
        }

        return $this;
    }

    /**
     * Check whether the address exists.
     * @return [type] [description]
     */
    private function placeDoesntExist()
    {
        return $this->place['status'] == self::ZERO_RESULTS;
    }

    /**
     * Retrieve the place information.
     * @return collection
     */
    public function retrieve()
    {
        return collect($this->place['results'])->collapse();
    }

    /**
     * Retrieve the 'lat' and 'lng' for a given place.
     * @return array
     */
    public function location()
    {
        return $this->retrieve()['geometry']['location'];
    }
}