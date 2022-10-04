<?php

namespace app;

use app\lib\HttpClient;
use app\models\Model;
use app\repositories\timezonedb\listtimezone\ListOptions;
use app\repositories\timezonedb\Options;
use app\repositories\timezonedb\timezone\TimezoneOptions;
use app\repositories\timezonedb\TimezoneDB;

require __DIR__ . '/vendor/autoload.php';

$repo = new TimezoneDB("http://api.timezonedb.com/v2.1", "ZE1WBLF2UVHV", new HttpClient());
// var_dump($repo->getListTimezone(new ListOptions([
//     'format' => 'json',
// ])));

var_dump($repo->getTimezone(new TimezoneOptions([
    'format' => 'json',
    'by' => 'position',
    'lat' => 43.8617,
    'lng' => -79.3700
])));
