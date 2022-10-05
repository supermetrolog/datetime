<?php

namespace app\lib\sdk\timezonedb;

interface HttpClientInterface
{
    public function fetch(string $url);
}
