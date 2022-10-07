<?php

namespace app\models\dataload\interfaces;

interface TimezoneDBInterface
{
    public function getTimezone(array $config): ResponseInterface;
}
