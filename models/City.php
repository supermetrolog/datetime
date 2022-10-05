<?php


namespace app\models;

class City
{
    public function getCityByID(string $city_id): array
    {
        return ['id' => $city_id, 'lat' => 33.6883, 'lng' => -112.0833];
    }
}
