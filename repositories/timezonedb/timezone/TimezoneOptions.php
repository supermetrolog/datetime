<?php


namespace app\repositories\timezonedb\timezone;

use app\repositories\timezonedb\Options;

class TimezoneOptions extends Options
{
    public float $lat;
    public float $lng;
    public string $country;
    public string $city;
    public string $by = "position";
}
