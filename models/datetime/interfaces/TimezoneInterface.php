<?php

namespace app\models\datetime\interfaces;

interface TimezoneInterface
{
    public function getDST(): int;
    public function getOffset(): int;
    public function getZoneStart(): int;
    public function getZoneEnd(): ?int;
}
