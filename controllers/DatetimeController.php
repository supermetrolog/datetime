<?php

namespace app\controllers;

use app\lib\http\HttpClient;
use app\lib\response\JsonResponse;
use app\lib\sdk\timezonedb\TimezoneDB;
use app\models\City;
use app\models\datetime\Datetime;
use app\models\Timezone;
use Exception;
use PDO;

class DatetimeController
{
    public function actionLocalTime(): JsonResponse
    {
        if (!isset($_GET['city_id'])) {
            throw new Exception("query param \"city_id\" is required!");
        }
        if (!isset($_GET['utc_zero_time'])) {
            throw new Exception("query param \"utc_zero_time\" is required!");
        }
        $city_id = $_GET['city_id'];
        $utcZeroTime = $_GET['utc_zero_time'];

        $city = $this->getCityByID($city_id);
        if (!$city) {
            throw new Exception("city with id: \"$city_id\" not found");
        }
        $timezone = $this->getTimezoneByCityID($city_id);
        if (!$timezone) {
            throw new Exception("timezone for city with id: \"$city_id\" not found");
        }
        $datetimeModel = new Datetime($timezone);
        $localTime = $datetimeModel->getLocalTime($utcZeroTime, $city->latitude, $city->longitude);

        return new JsonResponse([
            'status' => 'OK',
            'city_id' => $city->id,
            'utc_zero_time' => $utcZeroTime,
            'format_utc_zero_time' => date('Y-m-d H:i:s', $utcZeroTime),
            'local_time' => $localTime,
            'format_local_time' => date('Y-m-d H:i:s', $localTime)
        ]);
    }

    public function actionUtcZeroTime()
    {
        if (!isset($_GET['city_id'])) {
            throw new Exception("query param \"city_id\" is required!");
        }
        if (!isset($_GET['local_time'])) {
            throw new Exception("query param \"local_time\" is required!");
        }
        $city_id = $_GET['city_id'];
        $localTime = $_GET['local_time'];

        $city = $this->getCityByID($city_id);
        if (!$city) {
            throw new Exception("city with id: \"$city_id\" not found");
        }
        $timezone = $this->getTimezoneByCityID($city_id);
        if (!$timezone) {
            throw new Exception("timezone for city with id: \"$city_id\" not found");
        }
        $datetimeModel = new Datetime($timezone);
        $utcZeroTime = $datetimeModel->getUTCZeroTime($localTime, $city->latitude, $city->longitude);
        return new JsonResponse([
            'status' => 'OK',
            'city_id' => $city->id,
            'local_time' => $localTime,
            'format_local_time' => date('Y-m-d H:i:s', $localTime),
            'utc_zero_time' => $utcZeroTime,
            'format_utc_zero_time' => date('Y-m-d H:i:s', $utcZeroTime)
        ]);
    }

    private function getCityByID(string $id): ?City
    {
        $pdo = new PDO('mysql:host=db;dbname=ft_extra;charset=utf8', 'user', 'password');
        $cityModel = new City($pdo);
        return $cityModel->getByID($id);
    }

    private function getTimezoneByCityID(string $city_id): ?Timezone
    {
        $pdo = new PDO('mysql:host=db;dbname=ft_extra;charset=utf8', 'user', 'password');
        $timezoneModel = new Timezone($pdo);
        return $timezoneModel->getByCityID($city_id);
    }
}
