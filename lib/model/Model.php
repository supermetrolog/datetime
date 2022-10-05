<?php

namespace app\lib\model;

use PDO;

abstract class Model
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function load(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
