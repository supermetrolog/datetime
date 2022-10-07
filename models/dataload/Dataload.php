<?php

namespace app\models\dataload;

use PDO;

use app\lib\http\HttpClient;
use app\lib\sdk\timezonedb\TimezoneDB;
use app\models\City;
use app\models\dataload\interfaces\ResponseInterface;
use app\models\dataload\interfaces\TimezoneDBInterface;
use app\models\Timezone;
use Exception;

class Dataload
{
    private PDO $db;
    private TimezoneDBInterface $timezoneDB;
    public function __construct(PDO $db, TimezoneDBInterface $timezoneDB)
    {
        $this->db = $db;
        $this->timezoneDB = $timezoneDB;
    }

    public function loadAll()
    {
        echo "START Loading\n";
        try {
            $this->db->beginTransaction();

            $this->deleteAllTimezones();

            $cities = $this->getAllCities();
            foreach ($cities as $city) {
                $tzData = $this->getTimezoneDbData($this->timezoneDB, $city->latitude, $city->longitude);
                if (!$this->createNewTimezone($this->db, $tzData, $city)) {
                    throw new Exception("timezone creating error", 1);
                }

                echo "saved timezone data for city with ID: " . $city->id . "\n";

                //Иначе слишком быстро идут запросы и апишка их блокирует
                sleep(1);
            }

            $this->db->commit();
        } catch (\Throwable $th) {
            $this->db->rollBack();
            throw $th;
        }
        echo "END Loading";
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
    private function getAllCities(): array
    {
        $cityModel = new City($this->db);
        return $cityModel->getAll();
    }
    private function deleteAllTimezones()
    {
        $timezoneModel = new Timezone($this->db);
        if (!$timezoneModel->deleteAll()) {
            throw new Exception("delete all rows error in timezone table", 1);
        }
    }
}
