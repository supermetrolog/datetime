<?php

namespace app\lib\response;

class JsonResponse
{
    public $response;
    public function __construct($data)
    {
        $this->response = $data;
        $this->response['status'] = 'OK';
    }
}
