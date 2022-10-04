<?php

namespace app\repositories\timezonedb;

interface HttpClientInterface
{
    public function fetch(string $url);
}
