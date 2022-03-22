<?php

namespace FsHub\Sdk\Payloads\Entities;

class Wind
{

    /**
     * Wind Speed (kts)
     * @var int
     */
    public readonly int $speed;

    /**
     * Wind Direction (cardinal degrees)
     * @var int
     */
    public readonly int $direction;

    public function fromArray(array $data): Wind
    {
        $this->speed = $data['speed'];
        $this->direction = $data['direction'];
        return $this;
    }
}