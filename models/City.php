<?php


namespace app\models;

use app\lib\model\Model;

class City extends Model
{

    public string $id;
    public string $country_iso3;
    public string $name;
    public float $latitude;
    public float $longitude;

    public function getAll(): array
    {
        $cities = [];
        $sql = "SELECT id, country_iso3, name, latitude, longitude FROM city";
        foreach ($this->db->query($sql) as $row) {
            $city = new self($this->db);
            $city->load($row);
            $cities[] = $city;
        }

        return $cities;
    }
    public function getByID(string $id): ?City
    {
        $sql = "SELECT id, country_iso3, name, latitude, longitude FROM city WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!$result) {
            return null;
        }
        $city = new self($this->db);
        $city->load($result);
        return $city;
    }
}
