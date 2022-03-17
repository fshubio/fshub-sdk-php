<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;

class FlightPlan
{

    use CastableEntity;

    /**
     * Flight number or callsign.
     * @var string
     */
    public string $callsign = Common::DEFAULT_STRING_VALUE;

    /**
     * The planned cruise level (in FL notation)
     * @var int
     */
    public int $cruiseLevel = Common::DEFAULT_INTEGER_VALUE;

    /**
     * The planned route information (waypoints, SIDs, STARS etc)
     * @var string
     */
    public string $route = Common::DEFAULT_STRING_VALUE;

    /**
     * Castable map.
     * @var string[]
     */
    protected static $castMap = [
        'callsign' => 'callsign',
        'cruise_lvl' => 'cruiseLevel',
        'route' => 'route',
    ];

}