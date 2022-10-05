<?php

namespace app\lib\response;

class ErrorResponse
{
    public $error;
    public function __construct($data)
    {
        $this->error = $data;
        $this->error['status'] = 'FAILED';
    }
}
