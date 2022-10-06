<?php


namespace app\lib\sdk\timezonedb;

use app\lib\sdk\timezonedb\listtimezone\ListOptions;
use app\lib\sdk\timezonedb\listtimezone\ListTimezone;
use app\lib\sdk\timezonedb\timezone\GetTimezone;
use app\lib\sdk\timezonedb\timezone\TimezoneOptions;
use app\models\datetime\interfaces\ResponseInterface;
use app\models\datetime\interfaces\TimezoneDBInterface;
use Exception;

class TimezoneDB implements TimezoneDBInterface
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

    public function getListTimezone(array $config): ResponseInterface
    {
        $options = new ListOptions($config);
        if (!isset($options->key)) $options->key = $this->key;
        $lt = new ListTimezone($this->baseUrl, $options);

        return $this->fetch($lt->getUrl());
    }

    public function getTimezone(array $config): ResponseInterface
    {
        $options = new TimezoneOptions($config);
        if (!isset($options->key)) $options->key = $this->key;
        $gtz = new GetTimezone($this->baseUrl, $options);

        return $this->fetch($gtz->getUrl());
    }
    private function fetch($url): ResponseInterface
    {
        $resp = json_decode($this->httpClient->fetch($url), true);
        if (!is_array($resp)) {
            throw new Exception("unknown data in http response with url: $url");
        }
        return new Response($resp);
    }
}
