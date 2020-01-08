## Laravel DarkSky
[![Software License][ico-license]](LICENSE.md)

This provides a Laravel style wrapper for the DarkSky api and simplifies writing tests against ever changing weather data.
For more information regarding request and response formats, visit: https://darksky.net/dev/docs

### Install

Require this package with composer using the following command:

``` bash
$ composer require lawnstarter/laravel-darksky
```

In Laravel 5.5, [service providers and aliases are automatically registered](https://laravel.com/docs/6.0/packages#package-discovery). Or you may manually add the service provider and aliases in your config/app.php file.

Add a new item to the `providers` array in `config/app.php`:
```php
Lawnstarter\LaravelDarkSky\LaravelDarkSkyServiceProvider::class,
```

Add a new item to the `aliases` array in `config/app.php`:
```php
'DarkSky' => \Lawnstarter\LaravelDarkSky\Facades\DarkSky::class,
```

### Configuration

Add the following line to the .env file:

```sh
DARKSKY_API_KEY=<your_darksky_api_key>
```


### Usage
For full details of response formats, visit: https://darksky.net/dev/docs/response

#### Required
##### location(lat, lon)
Pass in latitude and longitude coordinates for a basic response
``` php
DarkSky::location(lat, lon)->get();
```
#### Optional Parameters
For full details of optional parameters, visit: https://darksky.net/dev/docs/forecast

##### excludes([]) / includes([])
Specify which data blocks to exclude/include to reduce data transfer
```php
DarkSky::location(lat, lon)->excludes(['minutely','hourly', 'daily', 'alerts', 'flags'])->get();
DarkSky::location(lat, lon)->includes(['currently'])->get();
// Same output
```

##### atTime(t)
Pass in a unix timestamp to get forecast for that time.
Note: the timezone is relative to the given location

``` php
DarkSky::location(lat, lon)->atTime(timestamp)->get();
```
##### language(l)
Specify a language for text based responses
``` php
DarkSky::location(lat, lon)->language(lang)->get();
```
##### units(u)
Specify units for unit based responses
``` php
DarkSky::location(lat, lon)->units(units)->get();
```
##### extend()
Extend the "hourly" response from 48 to 168 hours.
Note: Does not work if used with an atTime() timestamp.
Please see: https://darksky.net/dev/docs/time-machine
``` php
DarkSky::location(lat, lon)->extend()->get();
```

#### Helpers
The following are shorthand helpers to add readability equal to using includes() with only one parameter. Note: only one may be used per query and only temperature specific data is returned
```php
->currently()
->minutely()
->hourly()
->daily()
->flags()
```
For example, these two statements are the same
```php
DarkSky::location(lat, lon)->hourly()
DarkSky::location(lat, lon)->includes(['hourly'])->get()->hourly
```

### DarkSky & Testing
To simplyfiy testing the static method to force the response to be a certain payload without actually hitting the DarkSky API was added.

```php
DarkSky::setTestResponse($testResponseValue);
```

When this value is not null, the DarkSky wrapper will always return this data. If the value is null, the DarkSky API will be queried in real-time.
To simplify testing further, sample test responses are available for you to use in your test classes

```php
<?php

use Lawnstarter\LaravelDarkSky\DarkSkySampleResponse;
use Lawnstarter\LaravelDarkSky\DarkSky;

class MyTestsDependOnDarksky extends TestCase {

    public function test_forecast() {
        ...
        $fakeForecast = DarkSkySampleResponse::forecast();
        DarkSky::setTestResponse($fakeForecast);
        ...
    }

    public function test_forecast_extended_hourly() {
        ...
        $fakeForecast = DarkSkySampleResponse::forecastExtendedHourly();
        DarkSky::setTestResponse($fakeForecast);
        ...
    }

    public function test_timemachine() {
        ...
        $fakeForecast = DarkSkySampleResponse::timemachine();
        DarkSky::setTestResponse($fakeForecast);
        ...
    }

}

```

| Method                                                | Sample Payload                                                                                                                                 |
|-------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------|
| ```DarkSkySampleResponse::forecast()```               | [See Sample Forecast JSON](https://github.com/lawnstarter/laravel-darksky/blob/master/resources/forecast.json)                                 |
| ```DarkSkySampleResponse::forecastExtendedHourly()``` | [See Sample Forecast Extended Hourly JSON](https://github.com/lawnstarter/laravel-darksky/blob/master/resources/forecast_extended_hourly.json) |
| ```DarkSkySampleResponse::timemachine()```            | [See Sample Time Machine JSON](https://github.com/lawnstarter/laravel-darksky/blob/master/resources/timemachine.json)                          |




### Credits

- [All Contributors][link-contributors]

### License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[link-contributors]: ../../contributors
