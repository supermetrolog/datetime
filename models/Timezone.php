<?php


namespace app\models;

use app\lib\model\Model;
use app\models\datetime\interfaces\TimezoneInterface;

class Timezone extends Model implements TimezoneInterface
{

    public int $id;
    public string $city_id;
    public int $offset;
    public int $dst;
    public int $zone_start;
    public ?int $zone_end;

    public function getAll(): array
    {
        $timezones = [];
        $sql = "SELECT id, city_id, offset, dst, zone_start, zone_end FROM timezone";
        foreach ($this->db->query($sql) as $row) {
            $timezone = new self($this->db);
            $timezone->load($row);
            $timezones[] = $timezone;
        }

        return $timezones;
    }
    public function getByID(int $id): ?Timezone
    {
        $sql = "SELECT id, city_id, offset, dst, zone_start, zone_end FROM timezone WHERE id = ?";
        return $this->fetchOne($sql, [$id]);
    }

    public function getByCityID(string $city_id): ?Timezone
    {
        $sql = "SELECT id, city_id, offset, dst, zone_start, zone_end FROM timezone WHERE city_id = ?";
        return $this->fetchOne($sql, [$city_id]);
    }
    public function create(): bool
    {
        $sql = "INSERT INTO timezone (city_id, offset, dst, zone_start, zone_end) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            $this->city_id,
            $this->offset,
            $this->dst,
            $this->zone_start,
            $this->zone_end
        ]);
        return $result;
    }
    public function deleteAll(): bool
    {
        $sql = "DELETE FROM timezone";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute();
    }
    private function fetchOne(string $sql, array $params): ?Timezone
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        if (!$result) {
            return null;
        }
        $timezone = new self($this->db);
        $timezone->load($result);
        return $timezone;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
    public function getDST(): int
    {
        return $this->dst;
    }

    public function getZoneStart(): int
    {
        return $this->zone_start;
    }

    public function getZoneEnd(): ?int
    {
        return $this->zone_end;
    }
}
