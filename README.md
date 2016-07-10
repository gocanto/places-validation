# Places Validation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gocanto/places-validation.svg?style=flat-square)](https://img.shields.io/packagist/v/gocanto/places-validation.svg)
<a href="https://github.com/gocanto/google-autocomplete/blob/master/LICENSE.md"><img src="https://img.shields.io/npm/l/easiest-js-validator.svg" alt="License"></a>
[![Total Downloads](https://img.shields.io/packagist/dt/gocanto/places-validation.svg?style=flat-square)](https://img.shields.io/packagist/dt/gocanto/places-validation.svg?style=flat-square)


Places validation is a ***laravel*** library that will help you out to handle your user addresses. Its aim is making sure the addresses submitted by users are valid through 3rd party services, as google.

# Installation

Begin by installing the package through Composer. Run the following command in your terminal:

```bash
composer require gocanto/places-validation
```

Once composer is done, add the package service provider in the providers array in `config/app.php`:

```php
Gocanto\AddressValidation\ValidatorServiceProvider::class
```


# Settings

You will be able to set the validator driver into ```config/addressval.php``` file. At the moment, the package just has the ability to work with google, but others services are planned ahead.


The array driver looks like this: 
```php
'driver' => [

  //api key if required
  'key' => '',

  //driver object
  'name' => 'GeoogleGeocode',

  //api url
  'api' => 'http://maps.google.com/maps/api/geocode/json'
],
```

if you do not set the driver within this file, the default one will be used. 


# Implementation

To implement the validation within your project, you have to include the Checker object as so:
```php
use Gocanto\AddressValidation\Lib\Checker;
```


then, you can let laravel to handle the dependency injection for you, as so: 
```php
public function index(Checker $places)
{

  if ( ! $v = $places->validate('Guacara, Carabobo, Venezuela')) {
    //the place is not valid.
  }

  //retrieve the place information.
  dd($v->retrieve(), $v->location());
}
```


# Illustration

![example](https://github.com/gocanto/places-validation/blob/dev/src/Examples/google-output.png)



# Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities.


# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


# How can I thank you?
Why not star the github repo? I'd love the attention! Why not share the link for this repository on Twitter? Spread the word!


Don't forget to [follow me on twitter](https://twitter.com/gocanto)!

Thanks!

Gustavo Ocanto.
gustavoocanto@gmail.com



