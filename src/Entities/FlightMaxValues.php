<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CastableEntity;

class FlightMaxValues
{
    use CastableEntity;

    public static array $castMap = [
        'spd' => 'speed',
        'alt' => 'altitude',
    ];

    /**
     * Altitude in Feet (ft)
     * @var int|null
     */
    public ?int $altitude = null;

    /**
     * Speed in Knots (kts)
     * @var int|null
     */
    public ?int $speed = null;
}
