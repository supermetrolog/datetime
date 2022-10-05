<?php

namespace app\models\datetime\interfaces;

interface TimezoneDBInterface
{
    public function getTimezone(array $config): ResponseInterface;
}
