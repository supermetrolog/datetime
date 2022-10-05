<?php

namespace app\lib\http;

use app\lib\sdk\timezonedb\HttpClientInterface;

class HttpClient implements HttpClientInterface
{
    public function fetch(string $url)
    {
        return file_get_contents($url);
    }
}
