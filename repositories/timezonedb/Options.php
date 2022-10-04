<?php

namespace app\repositories\timezonedb;

use InvalidArgumentException;
use UnexpectedValueException;

class Options
{
    public string $key;
    public string $format = "json";


    public function __construct($config)
    {
        $this->setAttributes($config);
    }
    private function setAttributes($config)
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function toQueryString()
    {
        return http_build_query($this);
    }
}
