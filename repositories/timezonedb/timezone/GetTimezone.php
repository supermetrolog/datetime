<?php


namespace app\repositories\timezonedb\timezone;


class GetTimezone
{
    private string $urlPart = '/get-time-zone';
    private string $baseUrl;
    private TimezoneOptions $options;
    public function __construct(string $baseUrl, TimezoneOptions $options)
    {
        $this->baseUrl = $baseUrl;
        $this->options = $options;
    }
    public function getUrl(): string
    {
        return $this->baseUrl . $this->urlPart . "?" . $this->options->toQueryString();
    }
}
