<?php

namespace app\models\datetime;

use app\models\datetime\interfaces\TimezoneDBInterface;
use Exception;

date_default_timezone_set('Africa/Abidjan');

class Datetime
{
    public TimezoneDBInterface $timezoneDB;

    public function __construct(TimezoneDBInterface $timezoneDB)
    {
        $this->timezoneDB = $timezoneDB;
    }
    public function in_interval(int $value, int $start, int $end): bool
    {
        return $value > $start && $value < $end;
    }
    public function getLocalTime(int $utcZeroTime, int $lat, int $lng): int
    {
        $tzData = $this->timezoneDB->getTimezone(
            [
                'format' => 'json',
                'by' => 'position',
                'lat' => $lat,
                'lng' => $lng
            ]
        );
        if ($tzData->hasError()) {
            throw new Exception($tzData->getMessage());
        }
        $timeWithOffset = $utcZeroTime + $tzData->getOffset();
        if (!$tzData->getDST()) {
            return $timeWithOffset;
        }

        if ($this->in_interval($utcZeroTime, $tzData->getZoneStart(), $tzData->getZoneEnd())) {
            return  $timeWithOffset;
        }

        return $timeWithOffset - 60 * 60;
    }
    public function getUTCZeroTime(int $localTime, int $lat, int $lng): int
    {
        $tzData = $this->timezoneDB->getTimezone(
            [
                'format' => 'json',
                'by' => 'position',
                'lat' => $lat,
                'lng' => $lng
            ]
        );
        if ($tzData->hasError()) {
            throw new Exception($tzData->getMessage());
        }
        $timeWithOffset = $localTime - $tzData->getOffset();
        if (!$tzData->getDST()) {
            return $timeWithOffset;
        }

        if ($this->in_interval($localTime, $tzData->getZoneStart(), $tzData->getZoneEnd())) {
            return  $timeWithOffset;
        }

        return $timeWithOffset + 60 * 60;
    }
}
