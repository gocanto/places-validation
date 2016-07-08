<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Driver configuration info
    |--------------------------------------------------------------------------
    |
    | this file contains the configuration for the gocanto/places-validation package
    | 'driver' is the driver info container.
    */

    'driver' => [

        //api key if required
        'key' => '',

        //driver object
        'name' => 'GeoogleGeocode',

        //api url
        'api' => 'http://maps.google.com/maps/api/geocode/json'
    ],
];