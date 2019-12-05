<?php

namespace Lawnstarter\LaravelDarkSky;

class DarkSkySampleResponse
{
    public static function forecast()
    {
        $contents = @file_get_contents(__DIR__.'/../resources/forecast.json');
        if ($contents === false) {
            return null;
        }
        
        return json_decode($contents);
    }

    public static function forecastExtendedHourly()
    {
        $contents = @file_get_contents(__DIR__.'/../resources/forecast_extended_hourly.json');
        if ($contents === false) {
            return null;
        }
        
        return json_decode($contents);
    }

    public static function timemachine()
    {
        $contents = @file_get_contents(__DIR__.'/../resources/timemachine.json');
        if ($contents === false) {
            return null;
        }
        
        return json_decode($contents);
    }
}
