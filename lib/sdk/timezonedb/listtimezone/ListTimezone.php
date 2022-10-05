<?php


namespace app\lib\sdk\timezonedb\listtimezone;


class ListTimezone
{
    private string $urlPart = '/list-time-zone';
    private string $baseUrl;
    private ListOptions $options;
    public function __construct(string $baseUrl, ListOptions $options)
    {
        $this->baseUrl = $baseUrl;
        $this->options = $options;
    }
    public function getUrl(): string
    {
        return $this->baseUrl . $this->urlPart . "?" . $this->options->toQueryString();
    }
}
