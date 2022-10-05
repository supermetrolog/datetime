<?php

namespace app\controllers;

use app\lib\http\HttpClient;
use app\lib\sdk\timezonedb\TimezoneDB;
use app\models\City;
use app\models\datetime\Datetime;

class DatetimeController
{
    public function actionLocalTime()
    {
        $city_id = '040efa6e-3512-4523-a4dc-33e29aece663';
        // $utcZeroTime = 1670244734;
        $utcZeroTime = time();
        $lat = 43.8617;
        $lng = -79.3700;
        $cityModel = new City();
        $city = $cityModel->getCityByID($city_id);
        $datetimeModel = new Datetime(new TimezoneDB("http://api.timezonedb.com/v2.1", "ZE1WBLF2UVHV", new HttpClient()));
        return $datetimeModel->getLocalTime($utcZeroTime, $lat, $lng);
    }

    // public function actionUtcZeroTime()
    // {
    // }
}
