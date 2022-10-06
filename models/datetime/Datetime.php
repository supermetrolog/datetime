<?php

namespace app\models\datetime;

use app\models\Timezone;

date_default_timezone_set('Africa/Abidjan');

class Datetime
{
    public Timezone $timezone;

    public function __construct(Timezone $timezone)
    {
        $this->timezone = $timezone;
    }
    public function in_interval(int $value, int $start, int $end): bool
    {
        return $value > $start && $value < $end;
    }
    public function getLocalTime(int $utcZeroTime): int
    {
        $timeWithOffset = $utcZeroTime + $this->timezone->offset;
        if (!$this->timezone->dst) {
            return $timeWithOffset;
        }

        if ($this->in_interval($utcZeroTime, $this->timezone->zone_start, $this->timezone->zone_end)) {
            return  $timeWithOffset;
        }

        return $timeWithOffset - 60 * 60;
    }
    public function getUTCZeroTime(int $localTime): int
    {
        $timeWithOffset = $localTime - $this->timezone->offset;
        if (!$this->timezone->dst) {
            return $timeWithOffset;
        }

        if ($this->in_interval($localTime, $this->timezone->zone_start, $this->timezone->zone_end)) {
            return  $timeWithOffset;
        }

        return $timeWithOffset + 60 * 60;
    }
}
