<?php


namespace app\lib\sdk\timezonedb\timezone;

use app\lib\sdk\timezonedb\Options;

class TimezoneOptions extends Options
{
    public float $lat;
    public float $lng;
    public string $country;
    public string $city;
    public string $by = "position";
}
