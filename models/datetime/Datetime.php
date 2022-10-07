<?php

namespace app\models\datetime;

use app\models\datetime\interfaces\TimezoneInterface;
use app\models\Timezone;

date_default_timezone_set('Africa/Abidjan');

class Datetime
{
    public TimezoneInterface $timezone;

    public function __construct(TimezoneInterface $timezone)
    {
        $this->timezone = $timezone;
    }
    public function in_interval(int $value, int $start, int $end): bool
    {
        return $value > $start && $value < $end;
    }
    public function getLocalTime(int $utcZeroTime): int
    {
        $timeWithOffset = $utcZeroTime + $this->timezone->getOffset();
        if (!$this->timezone->getDST()) {
            return $timeWithOffset;
        }

        if ($this->in_interval($utcZeroTime, $this->timezone->getZoneStart(), $this->timezone->getZoneEnd())) {
            return $timeWithOffset;
        }

        return $timeWithOffset - 60 * 60;
    }
    public function getUTCZeroTime(int $localTime): int
    {
        $timeWithOffset = $localTime - $this->timezone->getOffset();
        if (!$this->timezone->getDST()) {
            return $timeWithOffset;
        }

        if ($this->in_interval($localTime, $this->timezone->getZoneStart(), $this->timezone->getZoneEnd())) {
            return  $timeWithOffset;
        }

        return $timeWithOffset + 60 * 60;
    }
}
