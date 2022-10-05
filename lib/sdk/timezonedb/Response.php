<?php

namespace app\lib\sdk\timezonedb;

use app\models\datetime\interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    private array $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function getStatus(): string
    {
        return $this->response['status'];
    }

    public function hasError(): bool
    {
        return $this->getStatus() != 'OK';
    }

    public function getMessage(): string
    {
        return $this->response['message'];
    }

    public function getDST(): int
    {
        return $this->response['dst'];
    }

    public function getOffset(): int
    {
        return $this->response['gmtOffset'];
    }

    public function getZoneStart(): int
    {
        return $this->response['zoneStart'];
    }
    public function getZoneEnd(): int
    {
        return $this->response['zoneEnd'];
    }
}
