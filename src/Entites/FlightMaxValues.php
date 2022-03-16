<?php

namespace FsHub\Sdk\Entites;

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
     * @var int
     */
    public int $altitude = 0;

    /**
     * Speed in Knots (kts)
     * @var int
     */
    public int $speed = 0;
    

}