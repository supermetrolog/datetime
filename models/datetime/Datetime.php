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
        // var_dump("utcZeroTime", date('Y-m-d H:i:s', $utcZeroTime));
        // var_dump("timeWithOffset", date('Y-m-d H:i:s', $timeWithOffset));
        if (!$tzData->getDST()) {
            return $timeWithOffset;
        }

        if ($this->in_interval($utcZeroTime, $tzData->getZoneStart(), $tzData->getZoneEnd())) {
            // var_dump("time with dst", date('Y-m-d H:i:s', $timeWithOffset - 60 * 60));
            return  $timeWithOffset;
        }
        if ($utcZeroTime > $tzData->getZoneEnd()) {
        }
        // var_dump("time without dst", $timeWithOffset);
        return $timeWithOffset;
    }

    public function in_interval(int $value, int $start, int $end): bool
    {
        return $value > $start && $value < $end;
    }
    public function is_winter_time(int $value, int $start, int $end): bool
    {
        if ($this->) {
        }
    }
}
