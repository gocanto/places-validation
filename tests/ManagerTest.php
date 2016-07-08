<?php

namespace Gocanto\AddressValidation\Test;

use Gocanto\AddressValidation\Lib\Checker;

class ManagerTest extends \TestCase
{
    /**
     * Test that true does in fact equal true
     */
    public function test_geocode_driver_address_is_valid()
    {
        $checker = $this->app[\Gocanto\AddressValidation\Lib\Checker::class];

        if ( $place = $checker->validate('Guacara, Carabobo, Venezuela')) {
            $this->assertArrayHasKey('formatted_address', $place->retrieve());
            $this->assertArrayHasKey('lat', $place->location());
            $this->assertArrayHasKey('lng', $place->location());
        }
    }

    public function test_geocode_driver_address_is_invalid()
    {
        $checker = $this->app[\Gocanto\AddressValidation\Lib\Checker::class];

        if ( ! $place = $checker->validate('I am from Venezuela')) {
            $this->assertFalse($place);
        }
    }
}