<?php

namespace Gocanto\AddressValidation\Tests;

use Gocanto\AddressValidation\Lib\Checker;
use Gocanto\AddressValidation\Tests\TestCase;

class ManagerTest extends TestCase
{
    public function test_geocode_driver_address_is_valid()
    {
        $checker = $this->app[\Gocanto\AddressValidation\Lib\Checker::class];

        if ($place = $checker->validate('Guacara, Carabobo, Venezuela')) {
            $this->assertArrayHasKey('geometry', $place->retrieve());
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

    public function test_validate_valid_place()
    {
        $rules = [
            'address' => 'valid_place'
        ];

        $data = [
            'address' => 'Guacara, Carabobo, Venezuela'
        ];

        $v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->passes());
    }

    public function test_validate_valid_place_passing_a_bad_address()
    {
        $rules = [
            'address' => 'valid_place'
        ];

        $data = [
            'address' => 'thi is not valid'
        ];

        $v = $this->app['validator']->make($data, $rules);

        $this->assertFalse($v->passes());
    }


}