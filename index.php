<?php

declare(strict_types=1);

namespace app;

use app\controllers\DatetimeController;
use app\lib\http\HttpClient;
use app\models\Model;
use app\lib\sdk\timezonedb\listtimezone\ListOptions;
use app\lib\sdk\timezonedb\Options;
use app\lib\sdk\timezonedb\timezone\TimezoneOptions;
use app\lib\sdk\timezonedb\TimezoneDB;

require __DIR__ . '/vendor/autoload.php';

$tz = new TimezoneDB("http://api.timezonedb.com/v2.1", "ZE1WBLF2UVHV", new HttpClient());
// var_dump($repo->getListTimezone(new ListOptions([
//     'format' => 'json',
// ])));

var_dump($tz->getTimezone([
    'format' => 'json',
    'by' => 'position',
    'lat' => 33.6367,
    'lng' => -84.4283
]));

$controller = new DatetimeController();
$time = $controller->actionLocalTime();
var_dump(date('Y-m-d H:i:s', $time));
var_dump($time);
