<?php

namespace app\models\datetime\interfaces;

interface ResponseInterface
{
    public function getDST(): int;
    public function hasError(): bool;
    public function getMessage(): string;
    public function getStatus(): string;
    public function getOffset(): int;
    public function getZoneStart(): int;
    public function getZoneEnd(): ?int;
}
