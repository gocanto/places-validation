<?php

namespace Gocanto\AddressValidation\Lib;

interface Contract
{
    /**
     * Validate whether a given address is valid.
     * @param  string $address
     * @return Mixed
     */
    public function validate(string $address);

    /**
     * Retrieve the place information.
     * @return collection
     */
    public function retrieve();

    /**
     * Retrieve the 'lat' and 'lng' for a given place.
     * @return array
     */
     public function location();
}
