<?php

namespace app\console\commands;

use app\lib\http\HttpClient;
use app\lib\sdk\timezonedb\TimezoneDB;
use app\models\dataload\Dataload;
use PDO;

class ReloadDataCommand
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function actionIndex()
    {
        $dataloadModel = new Dataload($this->db, new TimezoneDB("http://api.timezonedb.com/v2.1", "ZE1WBLF2UVHV", new HttpClient()));
        return $dataloadModel->loadAll();
    }
}
