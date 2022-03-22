<?php

namespace FsHub\Sdk\Payloads\Entities;

use FsHub\Sdk\Types\Common;

class UserConf
{
    /**
     * The aircraft tail number (as set by the user through the LRM Aircraft Manager feature
     * @var string
     */
    public readonly string $tailNumber;

    /**
     * The aircraft ICAO code (as set by the user through the LRM Aircraft Manager feature
     * @var string
     */
    public readonly string $icao;

    public function fromArray(array $data): UserConf
    {
        $this->tailNumber = $data['tail'];
        $this->icao = $data['icao'];
        return $this;
    }

}