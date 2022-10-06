<?php

namespace app\console\commands;

use app\lib\http\HttpClient;
use app\lib\sdk\timezonedb\TimezoneDB;
use app\models\City;
use app\models\datetime\interfaces\ResponseInterface;
use app\models\datetime\interfaces\TimezoneDBInterface;
use app\models\Timezone;
use Exception;
use PDO;

class ReloadDataCommand
{
    public function actionIndex(PDO $db)
    {
        try {
            $db->beginTransaction();

            $timezoneModel = new Timezone($db);
            if (!$timezoneModel->deleteAll()) {
                throw new Exception("delete all rows error in timezone table", 1);
            }
            $timezoneDB = new TimezoneDB("http://api.timezonedb.com/v2.1", "ZE1WBLF2UVHV", new HttpClient());
            $cityModel = new City($db);
            $cities = $cityModel->getAll();
            foreach ($cities as $city) {
                $tzData = $this->getTimezoneDbData($timezoneDB, $city->latitude, $city->longitude);
                if (!$this->createNewTimezone($db, $tzData, $city)) {
                    throw new Exception("timezone creating error", 1);
                }
                echo "saved timezone data for city with ID: " . $city->id . "\n";
                //Иначе слишком быстро идут запросы и апишка их блокирует
                sleep(1);
            }
            $db->commit();
            echo "END";
        } catch (\Throwable $th) {
            $db->rollBack();
            throw $th;
        }
    }
    private function createNewTimezone(PDO $db, ResponseInterface $tzData, City $city): bool
    {
        $newTz = new Timezone($db);
        $newTz->load([
            'city_id' => $city->id,
            'offset' => $tzData->getOffset(),
            'dst' => $tzData->getDST(),
            'zone_start' => $tzData->getZoneStart(),
            'zone_end' => $tzData->getZoneEnd(),
        ]);
        return $newTz->create();
    }
    private function getTimezoneDbData(TimezoneDBInterface $timezoneDB, float $lat, float $lng): ResponseInterface
    {
        $tzData = $timezoneDB->getTimezone([
            'format' => 'json',
            'by' => 'position',
            'lat' => $lat,
            'lng' => $lng
        ]);
        if ($tzData->hasError()) {
            throw new Exception($tzData->getMessage());
        }
        return $tzData;
    }
}
