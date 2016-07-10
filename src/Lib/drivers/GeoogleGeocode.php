<?php
/*
 * This file is part of the Address Validation package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\AddressValidation\Lib\drivers;

use Gocanto\AddressValidation\Lib\Contract;

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
        $place = collect($this->place['results'])->collapse();

        return $this->getAddressComponents($place)->merge(
            [
                'geometry' => $place->get('geometry'),
                'place_id' => $place->get('place_id')
            ]
        );
    }

    /**
     * Builds the address components collection.
     * @param  Collection $place
     * @return Collection
     */
    private function getAddressComponents($place)
    {
        $components = $place->get('address_components');

        return collect($components)->map(function($item)
        {
            return [
                $item["types"][0] => [
                    'long_name' => $item['long_name'],
                    'short_name' => $item['short_name']
                ]
            ];
        })->collapse();
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