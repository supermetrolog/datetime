<?php


namespace app\repositories\timezonedb;

use app\repositories\timezonedb\listtimezone\ListOptions;
use app\repositories\timezonedb\listtimezone\ListTimezone;
use app\repositories\timezonedb\timezone\GetTimezone;
use app\repositories\timezonedb\timezone\TimezoneOptions;

class TimezoneDB
{

    private string $baseUrl;
    private string $key;
    private HttpClientInterface $httpClient;
    public function __construct(string $baseUrl, string $key, HttpClientInterface $httpClient)
    {
        $this->baseUrl = $baseUrl;
        $this->key = $key;
        $this->httpClient = $httpClient;
    }

    public function getListTimezone(ListOptions $options)
    {
        if (!isset($options->key)) $options->key = $this->key;
        $lt = new ListTimezone($this->baseUrl, $options);

        try {
            return $this->httpClient->fetch($lt->getUrl());
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getTimezone(TimezoneOptions $options)
    {
        if (!isset($options->key)) $options->key = $this->key;
        $lt = new GetTimezone($this->baseUrl, $options);

        try {
            return $this->httpClient->fetch($lt->getUrl());
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
