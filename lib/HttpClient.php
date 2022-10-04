<?php

namespace app\lib;

use app\repositories\timezonedb\HttpClientInterface;

class HttpClient implements HttpClientInterface
{
    public function fetch(string $url)
    {
        return file_get_contents($url);
    }
}
