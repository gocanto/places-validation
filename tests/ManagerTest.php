<?php

namespace Gocanto\AddressValidation\Tests;

use Gocanto\AddressValidation\Lib\Checker;
use Gocanto\AddressValidation\Tests\TestCase;

class ManagerTest extends TestCase
{
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